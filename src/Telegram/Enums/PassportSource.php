<?php

namespace SergiX44\Nutgram\Telegram\Enums;

enum PassportSource: string
{
    case DATA = 'data';
    case FRONT_SIDE = 'front_side';
    case REVERSE_SIDE = 'reverse_side';
    case SELFIE = 'selfie';
    case FILE = 'file';
    case FILES = 'files';
}
