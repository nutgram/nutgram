<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use Psr\Http\Message\StreamInterface;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

/**
 * An animated profile photo in the MPEG4 format.
 * @see https://core.telegram.org/bots/api#inputprofilephotoanimated
 */
class InputProfilePhotoAnimated extends InputProfilePhoto
{
    /**
     * The animated profile photo. Profile photos can't be reused and can only be uploaded as a new file,
     * so you can pass “attach://<file_attach_name>” if the photo was uploaded using multipart/form-data under <file_attach_name>.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $animation;

    /**
     * Optional. Timestamp in seconds of the frame that will be used as the static profile photo.
     * Defaults to 0.0.
     */
    public ?float $main_frame_timestamp = null;

    public function isLocal(): bool
    {
        return $this->animation instanceof InputFile;
    }

    public function getFilename(): string
    {
        return $this->animation->getFilename();
    }

    public function getStream(): StreamInterface
    {
        return $this->animation->getStream();
    }

    public function __construct(InputFile|string $animation, ?float $main_frame_timestamp = null)
    {
        parent::__construct();
        $this->animation = $animation;
        $this->main_frame_timestamp = $main_frame_timestamp;
    }


}
