<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;

/**
 * @psalm-api
 */
class Response implements JsonSerializable
{
    /** @var array<int, Block> */
    protected array $blocks = [];

    public function addBlock(Block $block): self
    {
        $this->blocks[] = $block;
        return $this;
    }

    /**
     * @return array{
     *   blocks: array<int, Block>
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'blocks' => $this->blocks,
        ];
    }
}
