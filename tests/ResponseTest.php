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
        self::assertSame('{"blocks":[]}', json_encode($response));
    }

    public function testTextResponse(): void
    {
        $response = new Response();
        $response->addBlock(new Text('testing'));
        self::assertSame(
            '{"blocks":[{"type":"section","text":{"type":"plain_text",'
                . '"text":"testing","emoji":true}}]}',
            json_encode($response),
        );
    }

    public function testResponseWithAttachment(): void
    {
        $response = new Response();
        // @phpstan-ignore method.deprecated
        $response->addAttachment(new TextAttachment('Foo!', 'Bar...'));
        self::assertSame(
            '{"blocks":[],"attachments":[{"color":"good","text":"Bar...","title":"Foo!"}]}',
            json_encode($response),
        );
    }
}
