<?php

declare(strict_types=1);

namespace Tests\Blocks;

use Omnicolor\Slack\Blocks\Option;
use Omnicolor\Slack\Blocks\StaticSelect;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function json_encode;

#[Small]
final class StaticSelectTest extends TestCase
{
    public function testConstructor(): void
    {
        $select = new StaticSelect(
            'Choose an option',
            'something-happened',
            'Select an item',
            [
                new Option('Test Foo', 'foo'),
                new Option('Test Bar', 'bar'),
            ]
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Choose an option"},'
                . '"accessory":{"type":"static_select",'
                . '"placeholder":{"type":"plain_text","text":"Select an item",'
                . '"emoji":true},"options":[{"text":{"type":"plain_text",'
                . '"text":"Test Foo","emoji":true},"value":"foo"},'
                . '{"text":{"type":"plain_text","text":"Test Bar",'
                . '"emoji":true},"value":"bar"}],'
                . '"action_id":"something-happened"}}',
            json_encode($select),
        );
    }

    public function testEmptyOptions(): void
    {
        $select = new StaticSelect('Foo', 'bar', 'Mitz');
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"static_select","placeholder":{'
                . '"type":"plain_text","text":"Mitz","emoji":true},'
                . '"options":[],"action_id":"bar"}}',
            json_encode($select),
        );
    }

    public function testConstructorWrongType(): void
    {
        self::expectException(UnexpectedValueException::class);
        self::expectExceptionMessage('Options must be Option objects');
        // @phpstan-ignore argument.type
        new StaticSelect('text', 'action', 'placeholder', ['Testing']);
    }

    public function testAddOption(): void
    {
        $select = new StaticSelect('Foo', 'bar', 'Mitz');
        $select->addOption(new Option('Foo', 'foo'));
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"static_select","placeholder":{'
                . '"type":"plain_text","text":"Mitz","emoji":true},"options":['
                . '{"text":{"type":"plain_text","text":"Foo","emoji":true},'
                . '"value":"foo"}],"action_id":"bar"}}',
            json_encode($select),
        );
    }

    public function testAddOptions(): void
    {
        $select = new StaticSelect('Foo', 'bar', 'Mitz');
        $select->addOptions(
            new Option('Foo', 'foo'),
            new Option('Bar', 'bar'),
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"static_select","placeholder":{'
                . '"type":"plain_text","text":"Mitz","emoji":true},"options":['
                . '{"text":{"type":"plain_text","text":"Foo","emoji":true},'
                . '"value":"foo"},{"text":{"type":"plain_text","text":"Bar",'
                . '"emoji":true},"value":"bar"}],"action_id":"bar"}}',
            json_encode($select),
        );
    }
}
