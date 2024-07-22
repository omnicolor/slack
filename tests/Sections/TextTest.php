<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\Text;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class TextTest extends TestCase
{
    public function testToStringSimple(): void
    {
        $text = new Text('This is a test');
        self::assertSame(
            '{"type":"section","text":{"type":"plain_text",'
                . '"text":"This is a test","emoji":true}}',
            (string)$text,
        );
    }

    public function testToStringWithoutEmoji(): void
    {
        $text = new Text('Another test', false);
        self::assertSame(
            '{"type":"section","text":{"type":"plain_text",'
                . '"text":"Another test","emoji":false}}',
            (string)$text,
        );
    }

    public function testJsonEncodeSimple(): void
    {
        $text = new Text('JSON encoding');
        self::assertSame(
            '{"type":"section","text":{"type":"plain_text",'
                . '"text":"JSON encoding","emoji":true}}',
            json_encode($text),
        );
    }
}
