<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Subblocks;

use JsonSerializable;
use Omnicolor\Slack\Subblock;
use Stringable;

/**
 * @psalm-api
 */
class CheckboxOption extends Subblock implements JsonSerializable, Stringable
{
    public function __construct(protected string $text, protected string $value)
    {
    }

    /**
     * @return array{
     *   text: array{
     *     type: string,
     *     text: string
     *   },
     *   value: string
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'text' => [
                'type' => self::TYPE_MARKDOWN,
                'text' => $this->text,
            ],
            'value' => $this->value,
        ];
    }
}
