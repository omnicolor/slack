<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Subblocks;

use JsonSerializable;
use Omnicolor\Slack\Subblock;
use Stringable;

/**
 * @psalm-api
 */
class Option extends Subblock implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected string $value,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return array{
     *   text: array{
     *     type: string,
     *     text: string,
     *     emoji: bool
     *   },
     *   value: string
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'text' => [
                'type' => self::TYPE_TEXT,
                'text' => $this->text,
                'emoji' => $this->emoji,
            ],
            'value' => $this->value,
        ];
    }
}
