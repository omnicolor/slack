<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use League\Uri\Uri;

use function abs;
use function hash_equals;
use function hash_hmac;
use function implode;
use function time;

/**
 * @psalm-api
 */
class SlashCommand
{
    public const string VERSION = 'v0';

    /**
     * Legacy validation token, already deprecated in version 0.
     */
    public string $token;

    /**
     * Identifier for the workspace of the Slack instance. Should always start
     * with a T.
     */
    public string $team_id;

    /**
     * Name of the Slack workspace. If you're logging in to a Slack workspace
     * through the website, it would be the part before .slack.com. Slack says
     * to not trust it cause it can change arbitrarily.
     */
    public string $team_domain;

    /**
     * Identifier for the channel the slash command was invoked in. Should
     * start with a C for a public or private channel or D for a direct message.
     */
    public string $channel_id;

    /**
     * Name of the channel. Channels can be renamed, so use with caution.
     */
    public string $channel_name;

    /**
     * Identifier of the user interacting with the slash command. Should start
     * with a U.
     */
    public string $user_id;

    /**
     * Name of the user when they invoked the slash command. Users can change
     * their names, so should not be relied on long-term.
     */
    public string $user_name;

    /**
     * Name of the slash command, including the slash. This will be whatever you
     * registered with Slack, but will allow you to have multiple slash commands
     * go to a common handler.
     */
    public string $command;

    /**
     * Any text that comes after the slash command.
     *
     * For example, if your slash command is called "foo" and a user types
     * "/foo testing a slash command", would be the string "testing a slash
     * command".
     */
    public string $text;

    /**
     * The Slack app's unique identifier. Should start with an A.
     */
    public ?string $api_app_id;

    /**
     * Whether the Slack app is part of an enterprise grid.
     *
     * Note that the documentation doesn't include this parameter.
     */
    public bool $is_enterprise_install;

    /**
     * If the instance is part of an enterprise grid, will be the unique
     * identifier for the enterprise. For non-enterprise installs will be null.
     */
    public ?string $enterprise_id = null;

    /**
     * If the instance is part of an enterprise grid, will the the enterprise's
     * name. For non-enterprise installs will be null.
     */
    public ?string $enterprise_name = null;

    /**
     * A temporary webhook URL that you can use to generate message responses.
     */
    public Uri $response_url;

    /**
     * A short-lived ID that will allow your app to open a modal.
     */
    public string $trigger_id;

    public function __construct(public string $request)
    {
        parse_str($request, $result);
        /**
         * @psalm-suppress MixedArgumentTypeCoercion
         * @phpstan-ignore argument.type
         */
        $this->initialize($result);
    }

    /**
     * Split out from __construct to force type hinting of $result.
     * @param array<string, string> $result
     */
    protected function initialize(array $result): void
    {
        $this->token = $result['token'];
        $this->team_id = $result['team_id'];
        $this->team_domain = $result['team_domain'];
        $this->channel_id = $result['channel_id'];
        $this->channel_name = $result['channel_name'];
        $this->user_id = $result['user_id'];
        $this->user_name = $result['user_name'];
        $this->command = $result['command'];
        $this->text = $result['text'];
        $this->api_app_id = $result['api_app_id'] ?? null;
        $this->is_enterprise_install = 'true' === ($result['is_enterprise_install'] ?? null);
        $this->response_url = Uri::new($result['response_url']);
        $this->trigger_id = $result['trigger_id'];

        if ($this->is_enterprise_install) {
            $this->enterprise_id = $result['enterprise_id'] ?? null;
            $this->enterprise_name = $result['enterprise_name'] ?? null;
        }
    }

    /**
     * Current way to verify that a request is a valid Slack request.
     */
    public function verify(string $secret, int $timestamp, string $hash): bool
    {
        $basestring = implode(':', [self::VERSION, $timestamp, $this->request]);
        return hash_equals(hash_hmac('sha256', $basestring, $secret), $hash);
    }

    /**
     * When Slack first launched, they included a token to verify that the
     * request was from Slack and thus valid. They've since realized the error
     * of this security system and replaced it with stronger signing methodology
     * in the verify method. The token is still included in requests, but
     * should not be used.
     */
    public function legacyVerify(string $token): bool
    {
        return $token === $this->token;
    }

    /**
     * Validate that the timestamp is within five minutes to prevent replay
     * attacks.
     */
    public function validateTimestamp(int $timestamp): bool
    {
        return abs(time() - $timestamp) < 60 * 5;
    }
}
