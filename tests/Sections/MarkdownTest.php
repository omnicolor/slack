<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\Markdown;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class MarkdownTest extends TestCase
{
    public function testJsonEncodeSimple(): void
    {
        $text = new Markdown('JSON encode');
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"JSON encode"}}',
            json_encode($text),
        );
    }
}
