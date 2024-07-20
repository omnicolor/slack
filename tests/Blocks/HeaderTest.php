<?php

declare(strict_types=1);

namespace Tests\Blocks;

use Omnicolor\Slack\Blocks\Header;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class HeaderTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $text = new Header('Heading');
        self::assertSame(
            '{"type":"header","text":{"type":"plain_text",'
                . '"text":"Heading","emoji":true}}',
            json_encode($text),
        );
    }
}
