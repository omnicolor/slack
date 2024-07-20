<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Stringable;
use UnexpectedValueException;

use function array_values;

/**
 * @psalm-api
 */
class StaticSelect extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_STATIC_SELECT = 'static_select';

    /**
     * @param array<int, Option> $options
     */
    public function __construct(
        protected string $text,
        protected string $action_id,
        protected string $placeholder_text,
        protected array $options = [],
        protected bool $emoji = true,
    ) {
        foreach ($options as $option) {
            /** @psalm-suppress RedundantConditionGivenDocblockType */
            if ($option instanceof Option) {
                continue;
            }
            // @phpstan-ignore deadCode.unreachable
            throw new UnexpectedValueException(
                'StaticSelect options must be an Option',
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

    /**
     * @return array{
     *   type: string,
     *   text: array{
     *     type: string,
     *     text: string
     *   },
     *   accessory: array{
     *     type: string,
     *     placeholder: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
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
                'type' => self::TYPE_STATIC_SELECT,
                'placeholder' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->placeholder_text,
                    'emoji' => $this->emoji,
                ],
                'options' => $this->options,
                'action_id' => $this->action_id,
            ],
        ];
    }
}
