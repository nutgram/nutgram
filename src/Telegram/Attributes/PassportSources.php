<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

class PassportSources extends BaseEnum
{
    public const DATA = 'data';
    public const FRONT_SIDE = 'front_side';
    public const REVERSE_SIDE = 'reverse_side';
    public const SELFIE = 'selfie';
    public const FILE = 'file';
    public const FILES = 'files';
    public const TRANSLATION_FILE = 'translation_file';
    public const TRANSLATION_FILES = 'translation_files';
    public const UNSPECIFIED = 'unspecified';
}
