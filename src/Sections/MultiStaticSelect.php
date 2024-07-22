<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Omnicolor\Slack\Subblock;
use Omnicolor\Slack\Traits\HasOptions;
use Stringable;

/**
 * @psalm-api
 */
class MultiStaticSelect extends Block implements JsonSerializable, Stringable
{
    use HasOptions;

    public const string TYPE_MULTI_SELECT = 'multi_static_select';

    /**
     * @param array<int, Subblock> $options
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
     *     options: array<int, Subblock>,
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
                'type' => self::TYPE_MULTI_SELECT,
                'placeholder' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->placeholder_text,
                    'emoji' => $this->emoji,
                ],
                'options' => array_values($this->options),
                'action_id' => $this->action_id,
            ],
        ];
    }
}
