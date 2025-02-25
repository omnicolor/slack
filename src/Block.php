<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Omnicolor\Slack\Actions\Button as ActionButton;
use Omnicolor\Slack\Contexts\PlainText;
use Omnicolor\Slack\Dividers\Divider;
use Omnicolor\Slack\Sections\Button as SectionButton;
use Omnicolor\Slack\Sections\Fields;
use Omnicolor\Slack\Sections\Image;
use Omnicolor\Slack\Sections\LinkButton;
use Omnicolor\Slack\Sections\Markdown;
use Omnicolor\Slack\Sections\OverflowMenu;
use Omnicolor\Slack\Sections\RadioButtons;
use Omnicolor\Slack\Sections\TextField;
use Omnicolor\Slack\Sections\UsersSelect;
use Override;
use Stringable;

use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * @phpstan-import-type SerializedButton from ActionButton as SerializedActionButton
 * @phpstan-import-type SerializedButton from SectionButton as SerializedSectionButton
 * @phpstan-import-type SerializedDivider from Divider
 * @phpstan-import-type SerializedFields from Fields
 * @phpstan-import-type SerializedImage from Image
 * @phpstan-import-type SerializedLinkButton from LinkButton
 * @phpstan-import-type SerializedMarkdown from Markdown
 * @phpstan-import-type SerializedOverflowMenu from OverflowMenu
 * @phpstan-import-type SerializedPlainText from PlainText
 * @phpstan-import-type SerializedRadioButtons from RadioButtons
 * @phpstan-import-type SerializedTextField from TextField
 * @phpstan-import-type SerializedUsersSelect from UsersSelect
 * @phpstan-type SerializedBlock (
 *     SerializedActionButton |
 *     SerializedDivider |
 *     SerializedFields |
 *     SerializedImage |
 *     SerializedLinkButton |
 *     SerializedMarkdown |
 *     SerializedOverflowMenu |
 *     SerializedPlainText |
 *     SerializedRadioButtons |
 *     SerializedSectionButton |
 *     SerializedTextField |
 *     SerializedUsersSelect
 * )
 */
abstract class Block implements JsonSerializable, Stringable
{
    public const string TYPE_ACTION = 'actions';
    public const string TYPE_MARKDOWN = 'mrkdwn';
    public const string TYPE_SECTION = 'section';
    public const string TYPE_TEXT = 'plain_text';

    /**
     * @psalm-suppress PossiblyUnusedMethod
     * @return SerializedBlock
     */
    #[Override]
    abstract public function jsonSerialize(): array;

    #[Override]
    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
