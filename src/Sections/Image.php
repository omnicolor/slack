<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use League\Uri\Uri;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedImage array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string
 *     },
 *     accessory: array{
 *         type: string,
 *         image_url: string,
 *         alt_text: string
 *     }
 * }
 */
class Image extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_IMAGE = 'image';

    protected Uri $url;

    public function __construct(
        protected string $text,
        string $url,
        protected string $alt_text,
        protected bool $emoji = true,
    ) {
        $this->url = Uri::new($url);
    }

    /**
     * @return SerializedImage
     */
    #[Override]
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
                'image_url' => (string)$this->url,
                'alt_text' => $this->alt_text,
            ],
        ];
    }
}
