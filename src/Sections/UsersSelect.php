<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class UsersSelect extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_USERS_SELECT = 'users_select';

    public function __construct(
        protected string $text,
        protected string $action_id,
        protected string $placeholder_text,
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
     *     placeholder: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
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
                'type' => self::TYPE_USERS_SELECT,
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
