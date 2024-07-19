<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

/**
 * @psalm-api
 */
class UsersSelect extends Block implements JsonSerializable, Stringable
{
    public function __construct(
        protected string $text,
        protected string $actionId,
        protected string $placeholderText,
        protected bool $placeholderEmoji = true,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $this->text,
            ],
            'accessory' => [
                'type' => 'users_select',
                'placeholder' => [
                    'type' => 'plain_text',
                    'text' => $this->placeholderText,
                    'emoji' => $this->placeholderEmoji,
                ],
                'action_id' => $this->actionId,
            ],
        ];
    }
}
