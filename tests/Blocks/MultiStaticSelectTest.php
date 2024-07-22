<?php

declare(strict_types=1);

namespace Tests\Blocks;

use Omnicolor\Slack\Blocks\MultiStaticSelect;
use Omnicolor\Slack\Subblocks\Option;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function json_encode;

#[Small]
final class MultiStaticSelectTest extends TestCase
{
    public function testConstructor(): void
    {
        $select = new MultiStaticSelect(
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
                . '"accessory":{"type":"multi_static_select",'
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
        $select = new MultiStaticSelect('Foo', 'bar', 'Mitz');
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"multi_static_select","placeholder":{'
                . '"type":"plain_text","text":"Mitz","emoji":true},'
                . '"options":[],"action_id":"bar"}}',
            json_encode($select),
        );
    }

    public function testConstructorWrongType(): void
    {
        self::expectException(UnexpectedValueException::class);
        self::expectExceptionMessage('Options must be Subblock objects');
        // @phpstan-ignore argument.type
        new MultiStaticSelect('text', 'action', 'placeholder', ['Testing']);
    }
}
