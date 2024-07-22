<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\Fields;
use Omnicolor\Slack\Sections\TextField;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function json_encode;

#[Small]
final class FieldsTest extends TestCase
{
    public function testAddField(): void
    {
        $fields = new Fields();
        $fields->addField(new TextField('testing'));
        self::assertSame(
            '{"type":"section","fields":[{"type":"plain_text","text":"testing",'
                . '"emoji":true}]}',
            (string)$fields,
        );
    }

    public function testAddFields(): void
    {
        $fields = new Fields();
        $fields->addFields(
            new TextField('Test 1'),
            new TextField('Test 2'),
        );
        self::assertSame(
            '{"type":"section","fields":['
                . '{"type":"plain_text","text":"Test 1","emoji":true},'
                . '{"type":"plain_text","text":"Test 2","emoji":true}'
                . ']}',
            json_encode($fields),
        );
    }

    public function testConstructor(): void
    {
        $fields = new Fields([
            new TextField('Test Foo'),
            new TextField('Test Bar'),
        ]);
        self::assertSame(
            '{"type":"section","fields":['
                . '{"type":"plain_text","text":"Test Foo","emoji":true},'
                . '{"type":"plain_text","text":"Test Bar","emoji":true}'
                . ']}',
            json_encode($fields),
        );
    }

    public function testConstructorWrongType(): void
    {
        self::expectException(UnexpectedValueException::class);
        self::expectExceptionMessage(
            'Fields object can only contain TextField objects',
        );
        // @phpstan-ignore argument.type
        new Fields(['Testing']);
    }
}
