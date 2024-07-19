<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

/**
 * @psalm-api
 */
class Text extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => 'section',
            'text' => [
                'type' => 'plain_text',
                'text' => $this->text,
                'emoji' => $this->emoji,
            ],
        ];
    }
}
