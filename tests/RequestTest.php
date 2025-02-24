<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\Request;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function file_exists;
use function strtotime;
use function time;

final class RequestTest extends TestCase
{
    public function testConstructorEmpty(): void
    {
        $request = new Request('');
        self::assertNull($request->app_id);
        self::assertNull($request->channel_id);
        self::assertNull($request->channel_name);
        self::assertNull($request->command);
        self::assertNull($request->enterprise_id);
        self::assertNull($request->enterprise_name);
        self::assertNull($request->is_enterprise_install);
        self::assertNull($request->response_url);
        self::assertNull($request->team_domain);
        self::assertNull($request->team_id);
        self::assertNull($request->text);
        // @phpstan-ignore property.deprecated
        self::assertNull($request->token);
        self::assertNull($request->trigger_id);
        self::assertNull($request->user_id);
        // @phpstan-ignore property.deprecated
        self::assertNull($request->user_name);
    }

    public function testConstructorValid(): void
    {
        $payload = 'token=gIkuvaNzQIHg97ATvDxqgjtO'
            . '&team_id=T0001'
            . '&team_domain=example'
            . '&enterprise_id=E0001'
            . '&enterprise_name=Globular%20Construct%20Inc'
            . '&channel_id=C2147483705'
            . '&channel_name=test'
            . '&user_id=U2147483697'
            . '&user_name=Steve'
            . '&command=/weather'
            . '&text=94070'
            . '&response_url=https://hooks.slack.com/commands/1234/5678'
            . '&trigger_id=13345224609.738474920.8088930838d88f008e0'
            . '&api_app_id=A123456'
            . '&is_enterprise_install=false';

        $request = new Request($payload);
        self::assertSame('A123456', (string)$request->app_id);
        self::assertSame('C2147483705', (string)$request->channel_id);
        self::assertSame('test', $request->channel_name);
        self::assertSame('/weather', $request->command);
        self::assertSame('E0001', (string)$request->enterprise_id);
        self::assertSame('Globular Construct Inc', $request->enterprise_name);
        self::assertFalse($request->is_enterprise_install);
        self::assertSame('https://hooks.slack.com/commands/1234/5678', (string)$request->response_url);
        self::assertSame('example', $request->team_domain);
        self::assertSame('T0001', (string)$request->team_id);
        self::assertSame('94070', $request->text);
        // @phpstan-ignore property.deprecated
        self::assertSame('gIkuvaNzQIHg97ATvDxqgjtO', $request->token);
        self::assertSame('13345224609.738474920.8088930838d88f008e0', $request->trigger_id);
        self::assertSame('U2147483697', (string)$request->user_id);
        // @phpstan-ignore property.deprecated
        self::assertSame('Steve', $request->user_name);
    }

    public function testInvalidAppId(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Invalid app id: 123456');
        new Request('api_app_id=123456');
    }

    public function testInvalidChannelId(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Invalid channel id: 123456');
        new Request('channel_id=123456');
    }

    public function testInvalidEnterpriseId(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Invalid enterprise id: 123456');
        new Request('enterprise_id=123456');
    }

    public function testInvalidTeamId(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Invalid team id: 123456');
        new Request('team_id=123456');
    }

    public function testInvalidUserId(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Invalid user id: 123456');
        new Request('user_id=123456');
    }

    public function testEnterpriseInstall(): void
    {
        $request = new Request('is_enterprise_install=true');
        self::assertTrue($request->is_enterprise_install);
    }

    public function testInvalidPayload(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Value must be a string or null');
        new Request('user_id[]=U123');
    }

    public function testVerifyEmpty(): void
    {
        if (!file_exists('.env')) {
            self::markTestSkipped('.env file not found');
        }
        self::assertFalse((new Request(''))->verify(time(), 'a'));
    }

    public function testVerifyTooOld(): void
    {
        if (!file_exists('.env')) {
            self::markTestSkipped('.env file not found');
        }
        $time = strtotime('-60 minutes');
        $payload = 'this+is+a+payload';
        $signature = hash_hmac(
            'sha256',
            implode(':', ['v0', $time, $payload]),
            'slack-secret',
        );
        $request = new Request($payload);
        self::assertFalse($request->verify($time, $signature));
    }

    public function testVerifyTooFuturistic(): void
    {
        if (!file_exists('.env')) {
            self::markTestSkipped('.env file not found');
        }
        $time = strtotime('+60 minutes');
        $payload = 'this+is+a+payload';
        $signature = hash_hmac(
            'sha256',
            implode(':', ['v0', $time, $payload]),
            'slack-secret',
        );
        $request = new Request($payload);
        self::assertFalse($request->verify($time, $signature));
    }

    public function testVerify(): void
    {
        if (!file_exists('.env')) {
            self::markTestSkipped('.env file not found');
        }

        $time = time();
        $payload = 'this+is+a+payload';
        $signature = hash_hmac(
            'sha256',
            implode(':', ['v0', $time, $payload]),
            'slack-secret',
        );
        $request = new Request($payload);
        self::assertTrue($request->verify($time, $signature));
    }

    public function testVerifyByToken(): void
    {
        $payload = 'token=gIkuvaNzQIHg97ATvDxqgjtO';
        $request = new Request($payload);
        // @phpstan-ignore method.deprecated
        self::assertTrue($request->verifyToken('gIkuvaNzQIHg97ATvDxqgjtO'));
        // @phpstan-ignore method.deprecated
        self::assertFalse($request->verifyToken('foo'));
    }
}
