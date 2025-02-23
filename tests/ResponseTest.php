<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\Attachments\TextAttachment;
use Omnicolor\Slack\Response;
use Omnicolor\Slack\Sections\Text;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class ResponseTest extends TestCase
{
    public function testEmptyResponse(): void
    {
        $response = new Response();
        self::assertSame('{"blocks":[],"response_type":"ephemeral"}', json_encode($response));
    }

    public function testTextResponse(): void
    {
        $response = new Response();
        $response->addBlock(new Text('testing'));
        self::assertSame(
            '{"blocks":[{"type":"section","text":{"type":"plain_text",'
                . '"text":"testing","emoji":true}}],"response_type":"ephemeral"}',
            json_encode($response),
        );
    }

    public function testResponseWithAttachment(): void
    {
        $response = new Response();
        // @phpstan-ignore method.deprecated
        $response->addAttachment(new TextAttachment('Foo!', 'Bar...'));
        self::assertSame(
            '{"blocks":[],'
                . '"response_type":"ephemeral",'
                . '"attachments":[{"color":"good","text":"Bar...","title":"Foo!"}]}',
            json_encode($response),
        );
    }

    public function testResponseToChannel(): void
    {
        $response = new Response();
        $response->sendToChannel();
        self::assertSame(
            '{"blocks":[],"response_type":"in_channel"}',
            json_encode($response),
        );
    }

    public function testResponseDeleteOriginal(): void
    {
        $response = new Response();
        $response->deleteOriginal();
        self::assertSame(
            '{"blocks":[],"response_type":"ephemeral","delete_original":true}',
            json_encode($response),
        );
    }

    public function testResponseReplaceOriginal(): void
    {
        $response = new Response();
        $response->replaceOriginal();
        self::assertSame(
            '{"blocks":[],"response_type":"ephemeral","replace_original":true}',
            json_encode($response),
        );
    }

    public function testResponseWithText(): void
    {
        $response = new Response();
        $response->setText('testing');
        self::assertSame(
            '{"blocks":[],"response_type":"ephemeral","text":"testing"}',
            json_encode($response),
        );
    }
}
