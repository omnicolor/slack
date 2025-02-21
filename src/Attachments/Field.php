<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Attachments;

use JsonSerializable;
use Override;

readonly class Field implements JsonSerializable
{
    public function __construct(
        public string $title,
        public string $value,
        public bool $short = true,
    ) {
    }

    /**
     * @return array{
     *     title: string,
     *     value: string,
     *     short: bool
     * }
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
     * @return array{
     *     title: string,
     *     value: string,
     *     short: bool
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
