<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Blocks;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Stringable;
use UnexpectedValueException;

use function array_values;

/**
 * @psalm-api
 */
class Fields extends Block implements JsonSerializable, Stringable
{
    /**
     * @param array<int, TextField> $fields
     */
    public function __construct(protected array $fields = [])
    {
        foreach ($fields as $field) {
            /** @psalm-suppress RedundantConditionGivenDocblockType */
            if ($field instanceof TextField) {
                continue;
            }
            // @phpstan-ignore deadCode.unreachable
            throw new UnexpectedValueException(
                'Fields object can only contain TextField objects',
            );
        }
    }

    public function addField(TextField $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function addFields(TextField ...$fields): self
    {
        $this->fields = $this->fields + array_values($fields);
        return $this;
    }

    /**
     * @return array{
     *   type: string,
     *   fields: array<int, TextField>
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_SECTION,
            'fields' => $this->fields,
        ];
    }
}
