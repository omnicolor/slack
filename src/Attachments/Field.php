<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Attachments;

use JsonSerializable;
use Override;

/**
 * @phpstan-type SerializedField array{title: string, value: string, short: bool}
 */
readonly class Field implements JsonSerializable
{
    public function __construct(
        public string $title,
        public string $value,
        public bool $short = true,
    ) {
    }

    /**
     * @return SerializedField
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'short' => $this->short,
        ];
    }

    /**
     * @return SerializedField
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
