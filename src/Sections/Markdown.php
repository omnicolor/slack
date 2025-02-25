<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Sections;

use JsonSerializable;
use Omnicolor\Slack\Block;
use Override;
use Stringable;

/**
 * @phpstan-type SerializedMarkdown array{
 *     type: string,
 *     text: array{
 *         type: string,
 *         text: string
 *     }
 * }
 */
class Markdown extends Block implements JsonSerializable, Stringable
{
    public function __construct(protected string $text)
    {
    }

    /**
     * @return SerializedMarkdown
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE_SECTION,
            'text' => [
                'type' => self::TYPE_MARKDOWN,
                'text' => $this->text,
            ],
        ];
    }
}
