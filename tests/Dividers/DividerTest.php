<?php

declare(strict_types=1);

namespace Tests\Dividers;

use Omnicolor\Slack\Dividers\Divider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class DividerTest extends TestCase
{
    public function testJsonEncode(): void
    {
        $divider = new Divider();
        self::assertSame('{"type":"divider"}', json_encode($divider));
    }
}
