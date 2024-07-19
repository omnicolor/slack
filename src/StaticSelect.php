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
    /**
     * @param array<int, Option> $options
     */
    public function __construct(
        protected string $text,
        protected string $actionId,
        protected string $placeholderText,
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
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => $this->text,
            ],
            'accessory' => [
                'type' => 'static_select',
                'placeholder' => [
                    'type' => 'plain_text',
                    'text' => $this->placeholderText,
                    'emoji' => $this->emoji,
                ],
                'options' => $this->options,
                'action_id' => $this->actionId,
            ],
        ];
    }
}
