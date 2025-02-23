<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Attachments;

use JsonSerializable;
use Omnicolor\Slack\Attachment;
use Override;

/**
 * Fields attachment is a container for zero or more fields, which the Slack
 * client will format into a table-like display automatically.
 */
class FieldsAttachment extends Attachment implements JsonSerializable
{
    /** @var array<int, Field> */
    protected array $fields = [];

    public function __construct(protected readonly string $title)
    {
    }

    public function addField(Field $field): FieldsAttachment
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * Return the attachment as an array.
     * @return array{
     *     title: string,
     *     fields: array<int, array{title: string, value: string, short: bool}>
     * }
     */
    public function toArray(): array
    {
        $self = [
            'title' => $this->title,
            'fields' => [],
        ];
        foreach ($this->fields as $field) {
            $self['fields'][] = $field->toArray();
        }
        return $self;
    }

    /**
     * @return array{
     *     title: string,
     *     fields: array<int, array{title: string, value: string, short: bool}>
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
