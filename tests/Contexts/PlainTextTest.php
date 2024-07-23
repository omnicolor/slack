<?php

declare(strict_types=1);

namespace Tests\Contexts;

use Omnicolor\Slack\Contexts\PlainText;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class PlainTextTest extends TestCase
{
    public function testJsonEncodeSimple(): void
    {
        $text = new PlainText('JSON encoding');
        self::assertSame(
            '{"type":"section","text":{"type":"plain_text",'
                . '"text":"JSON encoding","emoji":true}}',
            json_encode($text),
        );
    }
}
