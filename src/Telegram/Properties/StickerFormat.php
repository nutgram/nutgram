<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum StickerFormat: string
{
    case STATIC = 'static';
    case ANIMATED = 'animated';
    case VIDEO = 'video';
}
