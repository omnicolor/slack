<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use Dotenv\Dotenv;
use League\Uri\Uri;
use Omnicolor\Slack\ValueObjects\AppId;
use Omnicolor\Slack\ValueObjects\ChannelId;
use Omnicolor\Slack\ValueObjects\EnterpriseId;
use Omnicolor\Slack\ValueObjects\TeamId;
use Omnicolor\Slack\ValueObjects\UserId;
use RuntimeException;

use function abs;
use function assert;
use function dirname;
use function hash_equals;
use function hash_hmac;
use function implode;
use function is_string;
use function parse_str;
use function time;

class Request
{
    private const int FIVE_MINUTES = 300;

    /**
     * This is a verification token, a deprecated feature that you shouldn't
     * use anymore. It was used to verify that requests were legitimately
     * being sent by Slack to your app, but you should use the signed secrets
     * functionality to do this instead.
     * @deprecated
     */
    public readonly null|string $token;

    /**
     * The team ID that the command was triggered for.
     */
    public readonly TeamId|null $team_id;

    /**
     * The domain of the Slack team.
     */
    public readonly null|string $team_domain;

    /**
     * For commands triggered in an enterprise install, the enterprise ID.
     */
    public readonly EnterpriseId|null $enterprise_id;

    /**
     * The name of the enterprise (if an enterprise install).
     */
    public readonly null|string $enterprise_name;

    /**
     * The ID of the channel the command was triggered in.
     */
    public readonly ChannelId|null $channel_id;

    /**
     * The name of the channel when the command was triggered.
     */
    public readonly null|string $channel_name;

    /**
     * The ID of the user who triggered the command.
     */
    public readonly UserId|null $user_id;

    /**
     * The plain text name of the user who triggered the command. Do not rely
     * on this field as it has been phased out. Use the user_id instead.
     * @deprecated
     */
    public readonly null|string $user_name;

    /**
     * The command that was entered to trigger this request. This value can be
     * useful if you want to use a single Request URL to service multiple
     * slash commands, as it allows you to tell them apart.
     */
    public readonly null|string $command;

    /**
     * This is the part of the slash command after the command itself, and it
     * can contain absolutely anything the user might decide to type. It is
     * common to use this text parameter to provide extra context for the
     * command.
     */
    public readonly null|string $text;

    /**
     * A temporary webhook URL that you can use to generate message responses.
     */
    public readonly null|Uri $response_url;

    /**
     * A short-lived ID that will allow your app to open a modal.
     */
    public readonly null|string $trigger_id;

    /**
     * Your Slack app's unique identifier. Use this in conjunction with
     * request signing to verify context for inbound requests.
     */
    public readonly AppId|null $app_id;

    /**
     * Whether the command comes from a team that is part of an enterprise.
     */
    public readonly bool|null $is_enterprise_install;

    public function __construct(public readonly string $payload)
    {
        $properties = [];
        parse_str($payload, $properties);

        // @phpstan-ignore property.deprecated
        $this->token = $this->assertStringOrNull($properties['token'] ?? null);
        $this->team_domain = $this->assertStringOrNull($properties['team_domain'] ?? null);
        $this->enterprise_name = $this->assertStringOrNull($properties['enterprise_name'] ?? null);
        $this->channel_name = $this->assertStringOrNull($properties['channel_name'] ?? null);
        // @phpstan-ignore property.deprecated
        $this->user_name = $this->assertStringOrNull($properties['user_name'] ?? null);
        $this->command = $this->assertStringOrNull($properties['command'] ?? null);
        $this->text = $this->assertStringOrNull($properties['text'] ?? null);
        $this->trigger_id = $this->assertStringOrNull($properties['trigger_id'] ?? null);

        $team_id = $this->assertStringOrNull($properties['team_id'] ?? null);
        if (null === $team_id) {
            $this->team_id = null;
        } else {
            $this->team_id = new TeamId($team_id);
        }

        $enterprise_id = $this->assertStringOrNull($properties['enterprise_id'] ?? null);
        if (null === $enterprise_id) {
            $this->enterprise_id = null;
        } else {
            $this->enterprise_id = new EnterpriseId($enterprise_id);
        }

        $channel_id = $this->assertStringOrNull($properties['channel_id'] ?? null);
        if (null === $channel_id) {
            $this->channel_id = null;
        } else {
            $this->channel_id = new ChannelId($channel_id);
        }

        $user_id = $this->assertStringOrNull($properties['user_id'] ?? null);
        if (null === $user_id) {
            $this->user_id = null;
        } else {
            $this->user_id = new UserId($user_id);
        }

        $url = $this->assertStringOrNull($properties['response_url'] ?? null);
        if (null === $url) {
            $this->response_url = null;
        } else {
            $this->response_url = Uri::new($url);
        }

        $app_id = $this->assertStringOrNull($properties['api_app_id'] ?? null);
        if (null === $app_id) {
            $this->app_id = null;
        } else {
            $this->app_id = new AppId($app_id);
        }

        if (!isset($properties['is_enterprise_install'])) {
            $this->is_enterprise_install = null;
        } else {
            $this->is_enterprise_install = 'true' === $properties['is_enterprise_install'];
        }
    }

    /**
     * @param array<mixed, mixed>|string|null $value
     */
    private function assertStringOrNull(array|string|null $value): null|string
    {
        if (null === $value || is_string($value)) {
            return $value;
        }
        throw new RuntimeException('Value must be a string or null');
    }

    /**
     * @param int $timestamp X-Slack-Request-Timestamp header
     * @param string $signature X-Slack-Signature header
     * @throws RuntimeException
     */
    public function verify(int $timestamp, string $signature): bool
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $dotenv->required(['SLACK_SIGNING_SECRET'])->notEmpty();

        if (abs($timestamp - time()) > self::FIVE_MINUTES) {
            return false;
        }

        $base_string = implode(':', ['v0', $timestamp, $this->payload]);
        $secret = $_ENV['SLACK_SIGNING_SECRET'];
        assert(is_string($secret));
        return hash_equals(
            $signature,
            hash_hmac('sha256', $base_string, $secret),
        );
    }

    /**
     * @deprecated
     */
    public function verifyToken(string $token): bool
    {
        return $this->token === $token;
    }
}
