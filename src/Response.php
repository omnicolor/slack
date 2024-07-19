<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class Response
{
    /** @var array<int, Block> */
    protected array $blocks = [];

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function addBlock(Block $block): self
    {
        $this->blocks[] = $block;
        return $this;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function render(): string
    {
        $object = [
            'blocks' => $this->blocks,
        ];
        return json_encode($object, JSON_THROW_ON_ERROR);
    }
}
