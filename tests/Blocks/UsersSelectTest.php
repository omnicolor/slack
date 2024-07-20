<?php

declare(strict_types=1);

namespace Tests\Blocks;

use Omnicolor\Slack\Blocks\UsersSelect;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class UsersSelectTest extends TestCase
{
    public function testConstructor(): void
    {
        $select = new UsersSelect(
            'Choose an option',
            'something-happened',
            'Select an item',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Choose an option"},'
                . '"accessory":{"type":"users_select",'
                . '"placeholder":{"type":"plain_text","text":"Select an item",'
                . '"emoji":true},"action_id":"something-happened"}}',
            json_encode($select),
        );
    }
}
