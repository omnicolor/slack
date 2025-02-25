<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

use JsonSerializable;
use Omnicolor\Slack\Actions\Button as ActionButton;
use Omnicolor\Slack\Contexts\PlainText;
use Omnicolor\Slack\Dividers\Divider;
use Omnicolor\Slack\Headers\Header as HeadersHeader;
use Omnicolor\Slack\Sections\Button as SectionButton;
use Omnicolor\Slack\Sections\Checkboxes;
use Omnicolor\Slack\Sections\DatePicker;
use Omnicolor\Slack\Sections\Fields;
use Omnicolor\Slack\Sections\Header as SectionHeader;
use Omnicolor\Slack\Sections\Image;
use Omnicolor\Slack\Sections\LinkButton;
use Omnicolor\Slack\Sections\Markdown;
use Omnicolor\Slack\Sections\MultiConversationsSelect;
use Omnicolor\Slack\Sections\MultiStaticSelect;
use Omnicolor\Slack\Sections\OverflowMenu;
use Omnicolor\Slack\Sections\RadioButtons;
use Omnicolor\Slack\Sections\StaticSelect;
use Omnicolor\Slack\Sections\Text;
use Omnicolor\Slack\Sections\TextField;
use Omnicolor\Slack\Sections\TimePicker;
use Omnicolor\Slack\Sections\UsersSelect;
use Override;
use Stringable;

use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * @phpstan-import-type SerializedButton from ActionButton as SerializedActionButton
 * @phpstan-import-type SerializedButton from SectionButton as SerializedSectionButton
 * @phpstan-import-type SerializedCheckboxes from Checkboxes
 * @phpstan-import-type SerializedDatePicker from DatePicker
 * @phpstan-import-type SerializedDivider from Divider
 * @phpstan-import-type SerializedFields from Fields
 * @phpstan-import-type SerializedHeader from HeadersHeader as SerializedHeadersHeader
 * @phpstan-import-type SerializedHeader from SectionHeader as SerializedSectionHeader
 * @phpstan-import-type SerializedImage from Image
 * @phpstan-import-type SerializedLinkButton from LinkButton
 * @phpstan-import-type SerializedMarkdown from Markdown
 * @phpstan-import-type SerializedMultiConversationsSelect from MultiConversationsSelect
 * @phpstan-import-type SerializedMultiStaticSelect from MultiStaticSelect
 * @phpstan-import-type SerializedOverflowMenu from OverflowMenu
 * @phpstan-import-type SerializedPlainText from PlainText
 * @phpstan-import-type SerializedRadioButtons from RadioButtons
 * @phpstan-import-type SerializedStaticSelect from StaticSelect
 * @phpstan-import-type SerializedText from Text
 * @phpstan-import-type SerializedTextField from TextField
 * @phpstan-import-type SerializedTimePicker from TimePicker
 * @phpstan-import-type SerializedUsersSelect from UsersSelect
 * @phpstan-type SerializedBlock (
 *     SerializedActionButton |
 *     SerializedCheckboxes |
 *     SerializedDatePicker |
 *     SerializedDivider |
 *     SerializedFields |
 *     SerializedHeadersHeader |
 *     SerializedImage |
 *     SerializedLinkButton |
 *     SerializedMarkdown |
 *     SerializedMultiConversationsSelect |
 *     SerializedMultiStaticSelect |
 *     SerializedOverflowMenu |
 *     SerializedPlainText |
 *     SerializedRadioButtons |
 *     SerializedSectionButton |
 *     SerializedSectionHeader |
 *     SerializedStaticSelect |
 *     SerializedText |
 *     SerializedTextField |
 *     SerializedTimePicker |
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
