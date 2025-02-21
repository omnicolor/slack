<?php

declare(strict_types=1);

namespace Tests\Attachments;

use Omnicolor\Slack\Attachments\Field;
use PHPUnit\Framework\TestCase;

final class FieldTest extends TestCase
{
    public function testToArrayMinimum(): void
    {
        $field = new Field('Title', 'Value');
        $expected = json_encode(['title' => 'Title', 'value' => 'Value', 'short' => true]);
        self::assertSame($expected, json_encode($field));
    }

    public function testToArray(): void
    {
        $field = new Field('A Title', 'A Value', false);
        $expected = json_encode([
            'title' => 'A Title',
            'value' => 'A Value',
            'short' => false,
        ]);
        self::assertSame($expected, json_encode($field));
    }
}
