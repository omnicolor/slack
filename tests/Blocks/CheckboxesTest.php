<?php

declare(strict_types=1);

namespace Tests\Blocks;

use Omnicolor\Slack\Blocks\Checkboxes;
use Omnicolor\Slack\Subblocks\CheckboxOption;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function json_encode;

#[Small]
final class CheckboxesTest extends TestCase
{
    public function testConstructor(): void
    {
        $select = new Checkboxes(
            'Choose an option',
            'something-happened',
            [
                new CheckboxOption('Test Foo', 'foo'),
                new CheckboxOption('Test Bar', 'bar'),
            ]
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Choose an option"},"accessory":{'
                . '"type":"checkboxes","options":[{"text":{"type":"mrkdwn",'
                . '"text":"Test Foo"},"value":"foo"},'
                . '{"text":{"type":"mrkdwn","text":"Test Bar"'
                . '},"value":"bar"}],'
                . '"action_id":"something-happened"}}',
            json_encode($select),
        );
    }

    public function testEmptyOptions(): void
    {
        $select = new Checkboxes('Foo', 'bar');
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"checkboxes","options":[],'
                . '"action_id":"bar"}}',
            json_encode($select),
        );
    }

    public function testConstructorWrongType(): void
    {
        self::expectException(UnexpectedValueException::class);
        self::expectExceptionMessage('Options must be Subblock objects');
        // @phpstan-ignore argument.type
        new Checkboxes('text', 'action', ['Testing']);
    }

    public function testAddOption(): void
    {
        $select = new Checkboxes('Foo', 'bar');
        $select->addOption(new CheckboxOption('Foo', 'foo'));
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"checkboxes","options":['
                . '{"text":{"type":"mrkdwn","text":"Foo"},'
                . '"value":"foo"}],"action_id":"bar"}}',
            json_encode($select),
        );
    }

    public function testAddOptions(): void
    {
        $select = new Checkboxes('Foo', 'bar');
        $select->addOptions(
            new CheckboxOption('Foo', 'foo'),
            new CheckboxOption('Bar', 'bar'),
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Foo"},'
                . '"accessory":{"type":"checkboxes","options":['
                . '{"text":{"type":"mrkdwn","text":"Foo"},'
                . '"value":"foo"},{"text":{"type":"mrkdwn","text":"Bar"},'
                . '"value":"bar"}],"action_id":"bar"}}',
            json_encode($select),
        );
    }
}
