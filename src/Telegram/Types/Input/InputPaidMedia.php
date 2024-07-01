<?php


namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;

/**
 * This object describes the paid media to be sent. Currently, it can be one of
 * - {@see InputPaidMediaPhoto}
 * - {@see InputPaidMediaVideo}
 */
abstract class InputPaidMedia extends BaseType implements Uploadable
{
    /**
     * Type of the media
     */
    #[EnumOrScalar]
    public InputPaidMediaType|string $type;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
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
