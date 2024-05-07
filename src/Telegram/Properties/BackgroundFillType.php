<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum BackgroundFillType: string
{
    case SOLID = 'solid';
    case GRADIENT = 'gradient';
    case FREEFORM_GRADIENT = 'freeform_gradient';
}
