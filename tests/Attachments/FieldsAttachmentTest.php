<?php

declare(strict_types=1);

namespace Tests\Attachments;

use Omnicolor\Slack\Attachments\Field;
use Omnicolor\Slack\Attachments\FieldsAttachment;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

use function json_encode;

#[Group('slack')]
#[Small]
final class FieldsAttachmentTest extends TestCase
{
    public function testEmpty(): void
    {
        $attachment = new FieldsAttachment('Empty');
        $expected = [
            'title' => 'Empty',
            'fields' => [],
        ];
        self::assertSame($expected, $attachment->jsonSerialize());
    }

    public function testWithFields(): void
    {
        $attachment = new FieldsAttachment('Full');
        $attachment->addField(new Field('Field 1', 'Value 1', false))
            ->addField(new Field('Field 2', 'Value 2', true));
        $expected = [
            'title' => 'Full',
            'fields' => [
                [
                    'title' => 'Field 1',
                    'value' => 'Value 1',
                    'short' => false,
                ],
                [
                    'title' => 'Field 2',
                    'value' => 'Value 2',
                    'short' => true,
                ],
            ],
        ];
        self::assertSame($expected, $attachment->jsonSerialize());
    }

    public function testJsonEncode(): void
    {
        $attachment = new FieldsAttachment('Testing');
        $attachment->addField(new Field('Field A', 'Value A'));
        $expected = '{"title":"Testing","fields":[{"title":"Field A","value":"Value A","short":true}]}';
        self::assertSame($expected, json_encode($attachment));
    }
}
