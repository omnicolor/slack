<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Omnicolor\Slack\Subblock;
use Omnicolor\Slack\Traits\HasOptions;
use Override;
use Stringable;

/**
 * @phpstan-import-type SerializedSubblock from Subblock
 * @phpstan-type SerializedOverflowMenu array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string
 *     },
 *     accessory: array{
 *         type: string,
 *         options: array<int, SerializedSubblock>,
 *         action_id: string
 *     }
 * }
 */
class OverflowMenu extends Block implements JsonSerializable, Stringable
{
    use HasOptions;

    public const string TYPE_OVERFLOW = 'overflow';

    /**
     * @param array<int, Subblock> $options
     */
    public function __construct(
        protected string $text,
        protected string $action_id,
        protected array $options = [],
    ) {
        $this->verifyOptions();
    }

    /**
     * @return SerializedOverflowMenu
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $options = [];
        foreach ($this->options as $option) {
            $options[] = $option->jsonSerialize();
        }
        return [
            'type' => self::TYPE_SECTION,
            'text' => [
                'type' => self::TYPE_MARKDOWN,
                'text' => $this->text,
            ],
            'accessory' => [
                'type' => self::TYPE_OVERFLOW,
                'options' => $options,
                'action_id' => $this->action_id,
            ],
        ];
    }
}
