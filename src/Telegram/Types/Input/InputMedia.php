<?php


namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents the content of a media message to be sent. It should be one of
 * - {@see InputMediaAnimation InputMediaAnimation}
 * - {@see InputMediaDocument InputMediaDocument}
 * - {@see InputMediaAudio InputMediaAudio}
 * - {@see InputMediaPhoto InputMediaPhoto}
 * - {@see InputMediaVideo InputMediaVideo}
 */
abstract class InputMedia extends BaseType
{
    /**
     * Type of the result
     */
    public InputMediaType $type;
}
