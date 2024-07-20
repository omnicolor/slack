<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\LinkButton;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class LinkButtonTest extends TestCase
{
    public function testSerialize(): void
    {
        $button = new LinkButton(
            'Click this button',
            'Click me!',
            'button1',
            'click-me',
            'https://www.example.com',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Click this button"},"accessory":{'
                . '"type":"button","text":{"type":"plain_text",'
                . '"text":"Click me!","emoji":true},"value":"button1",'
                . '"action_id":"click-me","url":"https:\/\/www.example.com"}}',
            json_encode($button),
        );
    }
}
