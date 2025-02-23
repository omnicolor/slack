<?php

declare(strict_types=1);

namespace Tests\Exceptions;

use Omnicolor\Slack\Attachments\TextAttachment;
use Omnicolor\Slack\Exceptions\SlackException;
use PHPUnit\Framework\TestCase;

use function json_encode;

use const PHP_EOL;

class SlackExceptionTest extends TestCase
{
    public function testDefault(): void
    {
        $expected = (object)[
            'blocks' => [],
            'response_type' => 'ephemeral',
            'attachments' => [
                [
                    'color' => TextAttachment::COLOR_DANGER,
                    'text' => 'You must include at least one command '
                        . 'argument.' . PHP_EOL
                        . 'For example: `/roll init` to roll your character\'s '
                        . 'initiative.' . PHP_EOL . PHP_EOL
                        . 'Type `/roll help` for more help.',
                    'title' => 'Error',
                ],
            ],
        ];
        $exception = new SlackException();
        self::assertSame(200, $exception->getCode());
        self::assertSame('', $exception->getMessage());
        self::assertSame(json_encode($expected), json_encode($exception));
    }

    public function testSetMessage(): void
    {
        $expected = (object)[
            'blocks' => [],
            'response_type' => 'ephemeral',
            'attachments' => [
                [
                    'color' => TextAttachment::COLOR_DANGER,
                    'text' => 'This is a message',
                    'title' => 'Error',
                ],
            ],
        ];
        $exception = new SlackException('This is a message', 404);
        self::assertSame('This is a message', $exception->getMessage());
        self::assertSame(404, $exception->getCode());
        self::assertSame(json_encode($expected), json_encode($exception));
    }
}
