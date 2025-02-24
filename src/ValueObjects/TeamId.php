<?php

declare(strict_types=1);

namespace Omnicolor\Slack\ValueObjects;

use Override;
use RuntimeException;
use Stringable;

final readonly class TeamId implements Stringable
{
    public function __construct(public string $value)
    {
        if (!str_starts_with($value, 'T')) {
            throw new RuntimeException('Invalid team id: ' . $value);
        }
    }

    #[Override]
    public function __toString(): string
    {
        return $this->value;
    }
}
