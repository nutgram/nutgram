<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputProfilePhotoType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

/**
 * A static profile photo in the .JPG format.
 * @see https://core.telegram.org/bots/api#inputprofilephoto
 */
#[SkipConstructor]
class InputProfilePhotoStatic extends InputProfilePhoto
{
    /**
     * Type of the profile photo, must be static
     */
    #[EnumOrScalar]
    public InputProfilePhotoType|string $type = InputProfilePhotoType::STATIC;
    /**
     * The static profile photo.
     * Profile photos can't be reused and can only be uploaded as a new file,
     * so you can pass “attach://<file_attach_name>” if the photo was uploaded using multipart/form-data under <file_attach_name>.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $photo;

    public function isLocal(): bool
    {
        return $this->photo instanceof InputFile;
    }

    public function getFilename(): string
    {
        return $this->photo->getFilename();
    }

    public function getResource()
    {
        return $this->photo->getResource();
    }

    public function __construct(InputFile|string $photo)
    {
        parent::__construct();
        $this->photo = $photo;
    }
}
