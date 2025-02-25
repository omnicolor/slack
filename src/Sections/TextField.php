<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedTextField array{
 *     type: string,
 *     text: string,
 *     emoji: bool
 * }
 */
class TextField extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return SerializedTextField
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_TEXT,
            'text' => $this->text,
            'emoji' => $this->emoji,
        ];
    }
}
