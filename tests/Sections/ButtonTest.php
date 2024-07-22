<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\Button;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class ButtonTest extends TestCase
{
    public function testSerialize(): void
    {
        $button = new Button(
            'Click this button',
            'Click me!',
            'button1',
            'click-me',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Click this button"},"accessory":{'
                . '"type":"button","text":{"type":"plain_text",'
                . '"text":"Click me!","emoji":true},"value":"button1",'
                . '"action_id":"click-me"}}',
            json_encode($button),
        );
    }
}
