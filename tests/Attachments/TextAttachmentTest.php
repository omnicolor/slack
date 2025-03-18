<?php

declare(strict_types=1);

namespace Tests\Attachments;

use Omnicolor\Slack\Attachments\TextAttachment;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Group('slack')]
#[Small]
final class TextAttachmentTest extends TestCase
{
    /**
     * Test formatting a TextAttachment as an array.
     */
    public function testToArrayDefault(): void
    {
        $attachment = new TextAttachment('Title', 'Text');
        $expected = [
            'color' => TextAttachment::COLOR_SUCCESS,
            'text' => 'Text',
            'title' => 'Title',
        ];
        self::assertEqualsCanonicalizing($expected, $attachment->jsonSerialize());
    }

    /**
     * Test formatting a TextAttachment when giving a color.
     */
    public function testToArrayWithColor(): void
    {
        $attachment = new TextAttachment('Other', 'Black', '#000000');
        $expected = [
            'color' => '#000000',
            'text' => 'Black',
            'title' => 'Other',
        ];
        self::assertEqualsCanonicalizing($expected, $attachment->jsonSerialize());
    }

    /**
     * Test formatting a TextAttachment when adding a footer.
     */
    public function testWithFooter(): void
    {
        $attachment = (new TextAttachment('Footer Test', 'Black', '#000000'))
            ->addFooter('This is a footer');
        $expected = [
            'color' => '#000000',
            'footer' => 'This is a footer',
            'text' => 'Black',
            'title' => 'Footer Test',
        ];
        self::assertSame($expected, $attachment->jsonSerialize());
    }

    public function testToString(): void
    {
        $attachment = (new TextAttachment('toString Test', 'White', '#ffffff'))
            ->addFooter('This is a footer');
        self::assertSame(
            '{"color":"#ffffff","footer":"This is a footer","text":"White",'
                . '"title":"toString Test"}',
            (string)$attachment,
        );
    }
}
