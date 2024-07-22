<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\TextField;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class TextFieldTest extends TestCase
{
    public function testToStringSimple(): void
    {
        $text = new TextField('This is a test');
        self::assertSame(
            '{"type":"plain_text","text":"This is a test","emoji":true}',
            (string)$text,
        );
    }

    public function testToStringWithoutEmoji(): void
    {
        $text = new TextField('Another test', false);
        self::assertSame(
            '{"type":"plain_text","text":"Another test","emoji":false}',
            (string)$text,
        );
    }

    public function testJsonEncode(): void
    {
        $text = new TextField('JSON encoding');
        self::assertSame(
            '{"type":"plain_text","text":"JSON encoding","emoji":true}',
            json_encode($text),
        );
    }
}
