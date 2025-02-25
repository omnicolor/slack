<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedMultiConversationsSelect array{
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
 *         action_id: string
 *     }
 * }
 */
class MultiConversationsSelect extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_MULTI_CONVERSATIONS_SELECT = 'multi_conversations_select';

    public function __construct(
        protected string $text,
        protected string $action_id,
        protected string $placeholder_text,
        protected bool $emoji = true,
    ) {
    }

    /**
     * @return SerializedMultiConversationsSelect
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
                'type' => self::TYPE_MULTI_CONVERSATIONS_SELECT,
                'placeholder' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->placeholder_text,
                    'emoji' => $this->emoji,
                ],
                'action_id' => $this->action_id,
            ],
        ];
    }
}
