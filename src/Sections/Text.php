<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedText array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string,
 *         emoji: bool
 *     }
 * }
 */
class Text extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return SerializedText
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
