<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;

use function json_encode;

use const JSON_THROW_ON_ERROR;

abstract class Block implements JsonSerializable, Stringable
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    abstract public function jsonSerialize(): mixed;

    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
