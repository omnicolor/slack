<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\SlashCommand;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class SlashCommandTest extends TestCase
{
    protected SlashCommand $command;

    public function setUp(): void
    {
        $this->command = new SlashCommand(
            'token=xyzz0WbapA4vBCDEFasx0q6G'
                . '&team_id=T1DC2JH3J'
                . '&team_domain=testteamnow'
                . '&channel_id=G8PSS9T3V'
                . '&channel_name=foobar'
                . '&user_id=U2CERLKJA'
                . '&user_name=roadrunner'
                . '&command=%2Fwebhook-collect'
                . '&text='
                . '&response_url=https%3A%2F%2Fhooks.slack.com%2Fcommands'
                . '%2FT1DC2JH3J%2F397700885554%2F96rGlfmibIGlgcZRskXaIFfN'
                . '&trigger_id=398738663015.47445629121'
                . '.803a0bc887a14d10d2c447fce8b6703c'
        );
    }

    public function testConstructor(): void
    {
        self::assertSame('xyzz0WbapA4vBCDEFasx0q6G', $this->command->token);
        self::assertSame('T1DC2JH3J', $this->command->team_id);
        self::assertSame('testteamnow', $this->command->team_domain);
        self::assertSame('G8PSS9T3V', $this->command->channel_id);
        self::assertSame('foobar', $this->command->channel_name);
        self::assertSame('U2CERLKJA', $this->command->user_id);
        self::assertSame('roadrunner', $this->command->user_name);
        self::assertSame('/webhook-collect', $this->command->command);
        self::assertSame('', $this->command->text);
        self::assertNull($this->command->api_app_id);
        self::assertFalse($this->command->is_enterprise_install);
        self::assertSame(
            'https://hooks.slack.com/commands/T1DC2JH3J/397700885554/'
                . '96rGlfmibIGlgcZRskXaIFfN',
            (string)$this->command->response_url,
        );
        self::assertSame(
            '398738663015.47445629121.803a0bc887a14d10d2c447fce8b6703c',
            $this->command->trigger_id,
        );
    }

    public function testVerify(): void
    {
        $secret = '8f742231b10e8888abcd99yyyzzz85a5';
        $timestamp = 1531420618;
        $hash = 'a2114d57b48eac39b9ad189dd8316235a7b4a8d21a10bd27519666489c69b503';
        self::assertTrue($this->command->verify($secret, $timestamp, $hash));
    }

    public function testVerifyFails(): void
    {
        $secret = '8f742231b10e8888abcd99yyyzzz85a5';
        $timestamp = 1531420618;
        $hash = 'a2114d57b48eac39b9ad189dd8316235a7b4a8d21a10bd27519666489c69b501';
        self::assertFalse($this->command->verify($secret, $timestamp, $hash));
    }

    public function testLegacyVerify(): void
    {
        self::assertTrue(
            $this->command->legacyVerify('xyzz0WbapA4vBCDEFasx0q6G')
        );
    }

    public function testLegacyVerifyFails(): void
    {
        self::assertFalse(
            $this->command->legacyVerify('xyzz0WbapA4vBCDEFasx0q6g')
        );
    }

    public function testValidateTimestamp(): void
    {
        self::assertTrue($this->command->validateTimestamp(time()));
        self::assertFalse($this->command->validateTimestamp(time() - 301));
        self::assertFalse($this->command->validateTimestamp(time() + 301));
    }

    public function testEnterprise(): void
    {
        $command = new SlashCommand(
            'token=xyzz0WbapA4vBCDEFasx0q6G'
                . '&team_id=T1DC2JH3J'
                . '&team_domain=testteamnow'
                . '&channel_id=G8PSS9T3V'
                . '&channel_name=foobar'
                . '&user_id=U2CERLKJA'
                . '&user_name=roadrunner'
                . '&is_enterprise_install=true'
                . '&enterprise_id=E99DFUT'
                . '&enterprise_name=Foobar%20Inc'
                . '&command=%2Fwebhook-collect'
                . '&text='
                . '&response_url=https%3A%2F%2Fhooks.slack.com%2Fcommands'
                . '%2FT1DC2JH3J%2F397700885554%2F96rGlfmibIGlgcZRskXaIFfN'
                . '&trigger_id=398738663015.47445629121'
                . '.803a0bc887a14d10d2c447fce8b6703c'
        );
        self::assertTrue($command->is_enterprise_install);
        self::assertSame('E99DFUT', $command->enterprise_id);
        self::assertSame('Foobar Inc', $command->enterprise_name);
    }
}
