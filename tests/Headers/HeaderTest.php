<?php

declare(strict_types=1);

namespace Tests\Headers;

use Omnicolor\Slack\Headers\Header;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class HeaderTest extends TestCase
{
    public function testJsonEncodeSimple(): void
    {
        $header = new Header('JSON encoding');
        self::assertSame(
            '{"type":"header","text":{"type":"plain_text",'
                . '"text":"JSON encoding","emoji":true}}',
            json_encode($header),
        );
    }
}
