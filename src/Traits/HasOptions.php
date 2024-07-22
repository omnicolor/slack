<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Traits;

use Omnicolor\Slack\Subblock;
use UnexpectedValueException;

use function array_values;

trait HasOptions
{
    public function verifyOptions(): void
    {
        foreach ($this->options as $option) {
            /** @psalm-suppress RedundantConditionGivenDocblockType */
            if ($option instanceof Subblock) {
                continue;
            }
            // @phpstan-ignore deadCode.unreachable
            throw new UnexpectedValueException(
                'Options must be Subblock objects',
            );
        }
    }

    public function addOption(Subblock $option): self
    {
        $this->options[] = $option;
        return $this;
    }

    public function addOptions(Subblock ...$options): self
    {
        $this->options = $this->options + array_values($options);
        return $this;
    }
}
