<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Contexts;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedPlainText array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string,
 *         emoji: bool
 *     }
 * }
 */
class PlainText extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return SerializedPlainText
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_SECTION,
            'text' => [
                'type' => self::TYPE_TEXT,
                'text' => $this->text,
                'emoji' => $this->emoji,
            ],
        ];
    }
}
