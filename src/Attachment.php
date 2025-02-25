<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Omnicolor\Slack\Attachments\FieldsAttachment;
use Omnicolor\Slack\Attachments\TextAttachment;
use Override;
use Stringable;

use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * Attachment that can be added to a Slack Response.
 * @phpstan-import-type SerializedFieldsAttachment from FieldsAttachment
 * @phpstan-import-type SerializedTextAttachment from TextAttachment
 * @phpstan-type SerializedAttachment (SerializedTextAttachment | SerializedFieldsAttachment)
 */
abstract class Attachment implements JsonSerializable, Stringable
{
    public const string COLOR_DANGER = 'danger';
    public const string COLOR_INFO = '#439Fe0';
    public const string COLOR_SUCCESS = 'good';
    public const string COLOR_WARNING = 'warning';

    /**
     * @return SerializedAttachment
     */
    #[Override]
    abstract public function jsonSerialize(): array;

    #[Override]
    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
