<?php

declare(strict_types=1);

namespace Omnicolor\Slack;

enum ResponseType: string
{
    case Ephemeral = 'ephemeral';
    case InChannel = 'in_channel';
}
