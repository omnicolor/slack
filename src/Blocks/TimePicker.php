<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class TimePicker extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_TIMEPICKER = 'timepicker';

    protected DateTimeInterface $initial_time;

    public function __construct(
        protected string $text,
        protected string $placeholder_text,
        protected string $action_id,
        ?DateTimeInterface $initial_time = null,
        protected bool $emoji = true,
    ) {
        if (null === $initial_time) {
            $this->initial_time = new DateTimeImmutable();
        } else {
            $this->initial_time = $initial_time;
        }
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
     *     initial_time: string,
     *     placeholder: array{
     *       type: string,
     *       text: string,
     *       emoji: bool
     *     },
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
                'type' => self::TYPE_TIMEPICKER,
                'initial_time' => $this->initial_time->format('H:i'),
                'placeholder' => [
                    'type' => self::TYPE_TEXT,
                    'text' => $this->placeholder_text,
                    'emoji' => $this->emoji,
                ],
                'action_id' => $this->action_id,
            ],
        ];
    }
}
