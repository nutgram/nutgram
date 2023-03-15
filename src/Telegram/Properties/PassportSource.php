<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum PassportSource: string
{
    case DATA = 'data';
    case FRONT_SIDE = 'front_side';
    case REVERSE_SIDE = 'reverse_side';
    case SELFIE = 'selfie';
    case FILE = 'file';
    case FILES = 'files';
    case TRANSLATION_FILE = 'translation_file';
    case TRANSLATION_FILES = 'translation_files';
    case UNSPECIFIED = 'unspecified';
}
