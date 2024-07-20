<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class Markdown extends Block implements JsonSerializable, Stringable
{
    public function __construct(protected string $text)
    {
    }

    /**
     * @return array{
     *   type: string,
     *   text: array{
     *     type: string,
     *     text: string
     *   }
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_SECTION,
            'text' => [
                'type' => self::TYPE_MARKDOWN,
                'text' => $this->text,
            ],
        ];
    }
}
