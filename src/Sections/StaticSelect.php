<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Omnicolor\Slack\Subblock;
use Omnicolor\Slack\Traits\HasOptions;
use Override;
use Stringable;

/**
 * @phpstan-import-type SerializedSubblock from Subblock
 * @phpstan-type SerializedStaticSelect array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string
 *     },
 *     accessory: array{
 *         type: string,
 *         placeholder: array{
 *             type: string,
 *             text: string,
 *             emoji: bool
 *         },
 *         options: array<int, SerializedSubblock>,
 *         action_id: string
 *     }
 * }
 */
class StaticSelect extends Block implements JsonSerializable, Stringable
{
    use HasOptions;

    public const string TYPE_STATIC_SELECT = 'static_select';

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
     * @return SerializedStaticSelect
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $options = [];
        foreach ($this->options as $option) {
            $options[] = $option->jsonSerialize();
        }
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
                'options' => $options,
                'action_id' => $this->action_id,
            ],
        ];
    }
}
