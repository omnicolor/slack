<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Omnicolor\Slack\Traits\HasOptions;
use Stringable;

/**
 * @psalm-api
 */
class OverflowMenu extends Block implements JsonSerializable, Stringable
{
    use HasOptions;

    public const string TYPE_OVERFLOW = 'overflow';

    /**
     * @param array<int, Option> $options
     */
    public function __construct(
        protected string $text,
        protected string $action_id,
        protected array $options = [],
    ) {
        $this->verifyOptions();
    }

    /**
     * @return array{
     *   type: string,
     *   text: array{
     *     type: string,
     *     text: string
     *   },
     *   accessory: array{
     *     type: string,
     *     options: array<int, Option>,
     *     action_id: string
     *   }
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_SECTION,
            'text' => [
                'type' => self::TYPE_MARKDOWN,
                'text' => $this->text,
            ],
            'accessory' => [
                'type' => self::TYPE_OVERFLOW,
                'options' => $this->options,
                'action_id' => $this->action_id,
            ],
        ];
    }
}
