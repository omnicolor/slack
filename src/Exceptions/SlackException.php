<?php

declare(strict_types=1);

namespace Omnicolor\Slack\Exceptions;

use Exception;
use JsonSerializable;
use Omnicolor\Slack\Attachment;
use Omnicolor\Slack\Attachments\TextAttachment;
use Omnicolor\Slack\Block;
use Omnicolor\Slack\Response;
use Override;

use function assert;
use function is_string;

use const PHP_EOL;

/**
 * An exception that's meant to be shown to a user within a Slack client.
 * The message for the exception will be included in the text of a legacy
 * attachment with the color set to "danger".
 * @phpstan-import-type SerializedAttachment from Attachment
 * @phpstan-import-type SerializedBlock from Block
 */
class SlackException extends Exception implements JsonSerializable
{
    /**
     * HTTP status code to return with the response.
     * @var mixed
     */
    protected $code = 400;

    /**
     * Render the exception as a Slack Response to return to the client.
     * @return array{
     *     attachments?: array<int, SerializedAttachment>,
     *     blocks: array<int, SerializedBlock>,
     *     response_type: string,
     *     text?: string
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->render()->jsonSerialize();
    }

    /**
     * Render the exception as a Slack Response to return to the client.
     */
    public function render(): Response
    {
        assert(is_string($this->message));
        if ('' === $this->message) {
            $this->message = 'You must include at least one command '
                . 'argument.' . PHP_EOL
                . 'For example: `/roll init` to roll your character\'s '
                . 'initiative.' . PHP_EOL . PHP_EOL
                . 'Type `/roll help` for more help.';
        }
        // @phpstan-ignore method.deprecated
        return (new Response())
            ->addAttachment(new TextAttachment(
                'Error',
                $this->message,
                TextAttachment::COLOR_DANGER,
            ));
    }
}
