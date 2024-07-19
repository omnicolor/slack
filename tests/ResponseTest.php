<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\Response;
use Omnicolor\Slack\Text;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class ResponseTest extends TestCase
{
    public function testEmptyResponse(): void
    {
        $response = new Response();
        self::assertSame('{"blocks":[]}', $response->render());
    }

    public function testTextResponse(): void
    {
        $response = new Response();
        $response->addBlock(new Text('testing'));
        self::assertSame(
            '{"blocks":[{"type":"section","text":{"type":"plain_text",'
                . '"text":"testing","emoji":true}}]}',
            $response->render(),
        );
    }
}
