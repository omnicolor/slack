<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Override;

/**
 * @psalm-api
 */
class Response implements JsonSerializable
{
    /** @var array<int, Block> */
    protected array $blocks = [];

    /** @var array<int, Attachment> */
    protected array $attachments = [];

    /**
     * Attachments have been deprecated. However, there's no way in blocks to
     * include the color next to the message.
     * @deprecated See https://api.slack.com/reference/surfaces/formatting#when-to-use-attachments
     */
    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;
        return $this;
    }

    public function addBlock(Block $block): self
    {
        $this->blocks[] = $block;
        return $this;
    }

    /**
     * @return array{
     *     attachments?: array<int, Attachment>,
     *     blocks: array<int, Block>
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $self = [
            'blocks' => $this->blocks,
        ];
        if (0 !== count($this->attachments)) {
            $self['attachments'] = $this->attachments;
        }
        return $self;
    }
}
