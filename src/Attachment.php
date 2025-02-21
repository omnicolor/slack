<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;

/**
 * Attachment that can be added to a Slack Response.
 */
abstract class Attachment implements JsonSerializable
{
    public const string COLOR_DANGER = 'danger';
    public const string COLOR_INFO = '#439Fe0';
    public const string COLOR_SUCCESS = 'good';
    public const string COLOR_WARNING = 'warning';

    /**
     * Render the attachment as an array.
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;
}
