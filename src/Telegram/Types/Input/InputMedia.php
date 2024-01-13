<?php


namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;

/**
 * This object represents the content of a media message to be sent. It should be one of
 * - {@see InputMediaAnimation InputMediaAnimation}
 * - {@see InputMediaDocument InputMediaDocument}
 * - {@see InputMediaAudio InputMediaAudio}
 * - {@see InputMediaPhoto InputMediaPhoto}
 * - {@see InputMediaVideo InputMediaVideo}
 */
abstract class InputMedia extends BaseType implements Uploadable
{
    /**
     * Type of the result
     */
    #[EnumOrScalar]
    public InputMediaType|string $type;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $media;

    public function isLocal(): bool
    {
        return $this->media instanceof InputFile;
    }

    public function getResource()
    {
        return $this->media->getResource();
    }

    public function getFilename(): string
    {
        return $this->media->getFilename();
    }
}
