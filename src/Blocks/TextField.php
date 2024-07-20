<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class TextField extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return array{
     *   type: string,
     *   text: string,
     *   emoji: bool
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_TEXT,
            'text' => $this->text,
            'emoji' => $this->emoji,
        ];
    }
}
