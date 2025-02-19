<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use League\Uri\Uri;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class LinkButton extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_BUTTON = 'button';

    protected Uri $url;

    public function __construct(
        protected string $text,
        protected string $button_text,
        protected string $value,
        protected string $action_id,
        string $url,
        protected bool $emoji = true,
    ) {
        $this->url = Uri::new($url);
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
     *     text: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
     *     value: string,
     *     action_id: string,
     *     url: string
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
                'type' => self::TYPE_BUTTON,
                'text' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->button_text,
                    'emoji' => $this->emoji,
                ],
                'value' => $this->value,
                'action_id' => $this->action_id,
                'url' => (string)$this->url,
            ],
        ];
    }
}
