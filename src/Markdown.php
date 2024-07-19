<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

/**
 * @psalm-api
 */
class Markdown extends Block implements JsonSerializable, Stringable
{
    public function __construct(protected string $text)
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $this->text,
            ],
        ];
    }
}
