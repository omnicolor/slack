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
    /** @var array<int, Attachment> */
    protected array $attachments = [];
    /** @var array<int, Block> */
    protected array $blocks = [];
    protected null|string $text = null;
    protected ResponseType $type = ResponseType::Ephemeral;
    protected bool $delete_original = false;
    protected bool $replace_original = false;

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
     * Deletes the message referenced by the new payload. Used when building
     * interactive payloads. Without a "response_url" or "trigger_id" field,
     * this has no effect. The "original" in this case is a message created
     * by the bot, not one created by a user.
     */
    public function deleteOriginal(): self
    {
        $this->delete_original = true;
        return $this;
    }

    /**
     * @return array{
     *     attachments?: array<int, Attachment>,
     *     blocks: array<int, Block>,
     *     delete_original?: bool,
     *     replace_original?: bool,
     *     response_type: string,
     *     text?: string
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $self = [
            'blocks' => $this->blocks,
            'response_type' => $this->type->value,
        ];
        if (0 !== count($this->attachments)) {
            $self['attachments'] = $this->attachments;
        }
        if ($this->delete_original) {
            $self['delete_original'] = true;
        }
        if ($this->replace_original) {
            $self['replace_original'] = true;
        }
        if (null !== $this->text) {
            $self['text'] = $this->text;
        }
        return $self;
    }

    /**
     * Replaces the original message with this one. Used for building
     * interactive Slack interactions that might ask a series of questions.
     * Without a "response_url" or "trigger_id" field, this has no effect.
     * The "original" in this case is a message created by the bot, not one
     * created by a user.
     */
    public function replaceOriginal(): self
    {
        $this->replace_original = true;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * By default, messages are "ephemeral" and only seen by the person that
     * triggered them. If you want the response to be seen by everyone, this
     * method changes the type to "in_channel".
     */
    public function sendToChannel(): self
    {
        $this->type = ResponseType::InChannel;
        return $this;
    }
}
