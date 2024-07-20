<?php

declare(strict_types=1);

namespace Tests;

use Omnicolor\Slack\Image;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
final class ImageTest extends TestCase
{
    public function testJsonEncode(): void
    {
        $image = new Image(
            'Look at this image',
            'https://example.com/foo.png',
            'A nice example of Foo',
        );
        self::assertSame(
            '{"type":"section","text":{"type":"mrkdwn",'
                . '"text":"Look at this image"},"accessory":{'
                . '"type":"image","image_url":"https:\/\/example.com\/foo.png",'
                . '"alt_text":"A nice example of Foo"}}',
            json_encode($image),
        );
    }
}
