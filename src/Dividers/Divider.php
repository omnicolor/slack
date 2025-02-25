<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Dividers;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedDivider array{type: string}
 */
class Divider extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_DIVIDER = 'divider';

    /**
     * @return SerializedDivider
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return ['type' => self::TYPE_DIVIDER];
    }
}
