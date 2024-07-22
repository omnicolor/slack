<?php

declare(strict_types=1);

namespace Tests\Blocks;

use DateTimeImmutable;
use Omnicolor\Slack\Blocks\DatePicker;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class DatePickerTest extends TestCase
{
    public function testJsonSerializeDefaultDate(): void
    {
        $picker = new DatePicker(
            'Section text',
            'Placeholder text',
            'action_id',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Section text"},'
                . '"accessory":{"type":"datepicker",'
                . '"initial_date":"' . date('Y-m-d') . '","placeholder":{'
                . '"type":"plain_text","text":"Placeholder text","emoji":true},'
                . '"action_id":"action_id"}}',
            (string)$picker,
        );
    }

    public function testJsonSerializeSpecificDate(): void
    {
        $picker = new DatePicker(
            'Section text',
            'Placeholder text',
            'action_id',
            new DateTimeImmutable('2024-04-01'),
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Section text"},'
                . '"accessory":{"type":"datepicker",'
                . '"initial_date":"2024-04-01","placeholder":{'
                . '"type":"plain_text","text":"Placeholder text","emoji":true},'
                . '"action_id":"action_id"}}',
            (string)$picker,
        );
    }
}
