<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Omnicolor\Slack\Traits\HasOptions;
use Stringable;

/**
 * @psalm-api
 */
class StaticSelect extends Block implements JsonSerializable, Stringable
{
    use HasOptions;

    public const string TYPE_STATIC_SELECT = 'static_select';

    /**
     * @param array<int, Option> $options
     */
    public function __construct(
        protected string $text,
        protected string $action_id,
        protected string $placeholder_text,
        protected array $options = [],
        protected bool $emoji = true,
    ) {
        $this->verifyOptions();
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
     *     placeholder: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
     *     options: array<int, Option>,
     *     action_id: string
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
                'type' => self::TYPE_STATIC_SELECT,
                'placeholder' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->placeholder_text,
                    'emoji' => $this->emoji,
                ],
                'options' => $this->options,
                'action_id' => $this->action_id,
            ],
        ];
    }
}
