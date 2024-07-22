<?php

declare(strict_types=1);

namespace Tests\Sections;

use Omnicolor\Slack\Sections\MultiConversationsSelect;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class MultiConversationsSelectTest extends TestCase
{
    public function testConstructor(): void
    {
        $select = new MultiConversationsSelect(
            'Choose an option',
            'something-happened',
            'Select items',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Choose an option"},"accessory":{'
                . '"type":"multi_conversations_select","placeholder":{'
                . '"type":"plain_text","text":"Select items","emoji":true},'
                . '"action_id":"something-happened"}}',
            json_encode($select),
        );
    }
}
