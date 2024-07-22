<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;

/**
 * @psalm-api
 */
class DatePicker extends Block implements JsonSerializable, Stringable
{
    public const string TYPE_DATEPICKER = 'datepicker';

    protected DateTimeInterface $initial_date;

    public function __construct(
        protected string $text,
        protected string $placeholder_text,
        protected string $action_id,
        ?DateTimeInterface $initial_date = null,
        protected bool $emoji = true,
    ) {
        if (null === $initial_date) {
            $this->initial_date = new DateTimeImmutable();
        } else {
            $this->initial_date = $initial_date;
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
     *     initial_date: string,
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
                'type' => self::TYPE_DATEPICKER,
                'initial_date' => $this->initial_date->format('Y-m-d'),
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
