<?php

declare(strict_types=1);

namespace Tests\Sections;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Omnicolor\Slack\Sections\TimePicker;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class TimePickerTest extends TestCase
{
    public function testJsonSerializeDefaultDate(): void
    {
        $picker = new TimePicker(
            'Section text',
            'Placeholder text',
            'action_id',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Section text"},'
                . '"accessory":{"type":"timepicker",'
                . '"initial_time":"' . Carbon::now()->format('H:i') . '","placeholder":{'
                . '"type":"plain_text","text":"Placeholder text","emoji":true},'
                . '"action_id":"action_id"}}',
            (string)$picker,
        );
    }

    public function testJsonSerializeSpecificTime(): void
    {
        $picker = new TimePicker(
            'Section text',
            'Placeholder text',
            'action_id',
            CarbonImmutable::parse('2024-04-01 13:37'),
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn","text":"Section text"},'
                . '"accessory":{"type":"timepicker",'
                . '"initial_time":"13:37","placeholder":{'
                . '"type":"plain_text","text":"Placeholder text","emoji":true},'
                . '"action_id":"action_id"}}',
            (string)$picker,
        );
    }
}
