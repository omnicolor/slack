<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Attachments;

use JsonSerializable;
use Omnicolor\Slack\Attachment;
use Override;

/**
 * Fields attachment is a container for zero or more fields, which the Slack
 * client will format into a table-like display automatically.
 * @phpstan-import-type SerializedField from Field
 * @phpstan-type SerializedFieldsAttachment array{
 *     title: string,
 *     fields: array<int, SerializedField>
 * }
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
     * @return SerializedFieldsAttachment
     */
    #[Override]
    public function jsonSerialize(): array
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
}
