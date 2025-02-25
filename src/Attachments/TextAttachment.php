<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Attachments;

use JsonSerializable;
use Omnicolor\Slack\Attachment;
use Override;

/**
 * Simple text attachment for a Slack Response.
 * @phpstan-type SerializedTextAttachment array{
 *     color: string,
 *     footer?: string,
 *     text: string,
 *     title: string
 * }
 */
class TextAttachment extends Attachment implements JsonSerializable
{
    public function __construct(
        protected readonly string $title,
        protected readonly string $text,
        protected readonly string $color = self::COLOR_SUCCESS,
        protected ?string $footer = null,
    ) {
    }

    /**
     * Add a footer to the attachment.
     */
    public function addFooter(string $footer): TextAttachment
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @return SerializedTextAttachment
     */
    #[Override]
    public function jsonSerialize(): array
    {
        if (null === $this->footer) {
            return [
                'color' => $this->color,
                'text' => $this->text,
                'title' => $this->title,
            ];
        }

        return [
            'color' => $this->color,
            'footer' => $this->footer,
            'text' => $this->text,
            'title' => $this->title,
        ];
    }
}
