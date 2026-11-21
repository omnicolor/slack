<?php

declare(strict_types=1);

namespace Tests\Sections;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Omnicolor\Slack\Sections\DatePicker;
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
                . '"initial_date":"' . Carbon::now()->format('Y-m-d') . '","placeholder":{'
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
            CarbonImmutable::parse('2024-04-01'),
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
