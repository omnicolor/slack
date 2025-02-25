<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedHeader array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string,
 *         emoji: bool
 *     }
 * }
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
     * @return SerializedHeader
     */
    #[Override]
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
