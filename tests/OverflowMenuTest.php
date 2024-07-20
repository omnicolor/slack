<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\Option;
use Omnicolor\Slack\OverflowMenu;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function json_encode;

#[Small]
final class OverflowMenuTest extends TestCase
{
    public function testConstructor(): void
    {
        $overflow = new OverflowMenu(
            'Choose an option',
            'something-happened',
            [
                new Option('Test Foo', 'foo'),
                new Option('Test Bar', 'bar'),
            ]
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Choose an option"},"accessory":{"type":"overflow",'
                . '"options":[{"text":{"type":"plain_text","text":"Test Foo",'
                . '"emoji":true},"value":"foo"},{"text":{"type":"plain_text",'
                . '"text":"Test Bar","emoji":true},"value":"bar"}],'
                . '"action_id":"something-happened"}}',
            json_encode($overflow),
        );
    }

    public function testEmptyOptions(): void
    {
        $overflow = new OverflowMenu('Foo', 'bar');
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"overflow","options":[],'
                . '"action_id":"bar"}}',
            json_encode($overflow),
        );
    }

    public function testConstructorWrongType(): void
    {
        self::expectException(UnexpectedValueException::class);
        self::expectExceptionMessage(
            'OverflowMenu options must be an Option',
        );
        // @phpstan-ignore argument.type
        new OverflowMenu('text', 'action', ['Testing']);
    }

    public function testAddOption(): void
    {
        $overflow = new OverflowMenu('Foo', 'bar');
        $overflow->addOption(new Option('Foo', 'foo'));
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"overflow","options":['
                . '{"text":{"type":"plain_text","text":"Foo","emoji":true},'
                . '"value":"foo"}],"action_id":"bar"}}',
            json_encode($overflow),
        );
    }

    public function testAddOptions(): void
    {
        $overflow = new OverflowMenu('Foo', 'bar');
        $overflow->addOptions(
            new Option('Foo', 'foo'),
            new Option('Bar', 'bar'),
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"overflow","options":['
                . '{"text":{"type":"plain_text","text":"Foo","emoji":true},'
                . '"value":"foo"},{"text":{"type":"plain_text","text":"Bar",'
                . '"emoji":true},"value":"bar"}],"action_id":"bar"}}',
            json_encode($overflow),
        );
    }
}
