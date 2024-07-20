<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

/**
 * @psalm-api
 */
class Header extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_HEADER = 'header';

    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return array{
     *   type: string,
     *   text: array{
     *     type: string,
     *     text: string,
     *     emoji: bool
     *   }
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_HEADER,
            'text' => [
                'type' => self::TYPE_TEXT,
                'text' => $this->text,
                'emoji' => $this->emoji,
            ],
        ];
    }
}
