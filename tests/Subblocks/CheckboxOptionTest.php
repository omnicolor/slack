<?php

declare(strict_types=1);

namespace Tests\Subblocks;

use Omnicolor\Slack\Subblocks\CheckboxOption;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class CheckboxOptionTest extends TestCase
{
    public function testSerialize(): void
    {
        $option = new CheckboxOption('Test option', 'option-value');
        self::assertSame(
            '{"text":{"type":"mrkdwn","text":"Test option"},'
                . '"value":"option-value"}',
            json_encode($option),
        );
    }
}
