<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum MaskPositionPoint: string
{
    case FOREHEAD = 'forehead';
    case EYES = 'eyes';
    case MOUTH = 'mouth';
    case CHIN = 'chin';
}
