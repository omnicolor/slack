<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Dividers;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class Divider extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_DIVIDER = 'divider';

    /**
     * @return array{
     *   type: string
     * }
     */
    public function jsonSerialize(): array
    {
        return ['type' => self::TYPE_DIVIDER];
    }
}
