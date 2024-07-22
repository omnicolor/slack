<?php

declare(strict_types=1);

namespace Tests\Subblocks;

use Omnicolor\Slack\Subblocks\Option;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Small]
final class OptionTest extends TestCase
{
    public function testSerialize(): void
    {
        $option = new Option('Test option', 'option-value');
        self::assertSame(
            '{"text":{"type":"plain_text","text":"Test option","emoji":true},'
            . '"value":"option-value"}',
            json_encode($option),
        );
    }

    public function testToString(): void
    {
        $option = new Option('Test option', 'option-value');
        self::assertSame(
            '{"text":{"type":"plain_text","text":"Test option","emoji":true},'
            . '"value":"option-value"}',
            (string)$option,
        );
    }
}
