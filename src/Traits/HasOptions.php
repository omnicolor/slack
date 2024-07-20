<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Traits;

use Omnicolor\Slack\Option;
use UnexpectedValueException;

use function array_values;

trait HasOptions
{
    public function verifyOptions(): void
    {
        foreach ($this->options as $option) {
            /** @psalm-suppress RedundantConditionGivenDocblockType */
            if ($option instanceof Option) {
                continue;
            }
            // @phpstan-ignore deadCode.unreachable
            throw new UnexpectedValueException(
                'Options must be Option objects',
            );
        }
    }

    public function addOption(Option $option): self
    {
        $this->options[] = $option;
        return $this;
    }

    public function addOptions(Option ...$options): self
    {
        $this->options = $this->options + array_values($options);
        return $this;
    }
}
