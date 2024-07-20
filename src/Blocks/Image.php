<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class Image extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_IMAGE = 'image';

    public function __construct(
        protected string $text,
        protected string $url,
        protected string $alt_text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return array{
     *   type: string,
     *   text: array{
     *     type: string,
     *     text: string
     *   },
     *   accessory: array{
     *     type: string,
     *     image_url: string,
     *     alt_text: string
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
            'accessory' => [
                'type' => self::TYPE_IMAGE,
                'image_url' => $this->url,
                'alt_text' => $this->alt_text,
            ],
        ];
    }
}
