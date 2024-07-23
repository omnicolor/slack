<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Actions;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class Button extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_BUTTON = 'button';

    public function __construct(
        protected string $text,
        protected string $value,
        protected string $action_id,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return array{
     *   type: string,
     *   elements: array<int, array{
     *     type: string,
     *     text: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
     *     value: string,
     *     action_id: string
     *   }>
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_ACTION,
            'elements' => [
                [
                    'type' => self::TYPE_BUTTON,
                    'text' => [
                        'type' => self::TYPE_TEXT,
                        'text' => $this->text,
                        'emoji' => $this->emoji,
                    ],
                    'value' => $this->value,
                    'action_id' => $this->action_id,
                ],
            ],
        ];
    }
}
