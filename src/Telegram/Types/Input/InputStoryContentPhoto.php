<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputStoryContentType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;

/**
 * Describes a photo to post as a story.
 * @see https://core.telegram.org/bots/api#inputstorycontentphoto
 */
#[SkipConstructor]
class InputStoryContentPhoto extends InputStoryContent implements Uploadable
{
    /**
     * Type of the content, must be photo
     */
    #[EnumOrScalar]
    public InputStoryContentType|string $type = InputStoryContentType::PHOTO;

    /**
     * The photo to post as a story. The photo must be of the size 1080x1920 and must not exceed 10 MB.
     * The photo can't be reused and can only be uploaded as a new file, so you can pass “attach://<file_attach_name>” if the photo was uploaded using multipart/form-data under <file_attach_name>.
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
