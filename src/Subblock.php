<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * Subblocks are pieces of other blocks, but can't be directly added to
 * a layout. For example an option in a selector or a radio button.
 */
abstract class Subblock implements JsonSerializable, Stringable
{
    public const string TYPE_MARKDOWN = 'mrkdwn';
    public const string TYPE_SECTION = 'section';
    public const string TYPE_TEXT = 'plain_text';

    /**
     * @psalm-suppress PossiblyUnusedMethod
     * @return array<string, mixed>
     */
    abstract public function jsonSerialize(): array;

    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
