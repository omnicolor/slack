<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Subblocks;

use JsonSerializable;
use Omnicolor\Slack\Subblock;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedCheckboxOption array{
 *     text: array{
 *         type: string,
 *         text: string
 *     },
 *     value: string
 * }
 */
class CheckboxOption extends Subblock implements JsonSerializable, Stringable
{
    public function __construct(protected string $text, protected string $value)
    {
    }

    /**
     * @return SerializedCheckboxOption
     */
    #[Override]
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
