<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputStoryContentType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;

/**
 * Describes a video to post as a story.
 * @see https://core.telegram.org/bots/api#inputstorycontentvideo
 */
#[SkipConstructor]
class InputStoryContentVideo extends InputStoryContent implements Uploadable
{
    /**
     * Type of the content, must be video
     */
    #[EnumOrScalar]
    public InputStoryContentType|string $type = InputStoryContentType::VIDEO;

    /**
     * The video to post as a story. The video must be of the size 720x1280, streamable, encoded with H.265 codec, with key frames added each second in the MPEG4 format, and must not exceed 30 MB.
     * The video can't be reused and can only be uploaded as a new file, so you can pass “attach://<file_attach_name>” if the video was uploaded using multipart/form-data under <file_attach_name>.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $video;

    /**
     * Optional. Precise duration of the video in seconds; 0-60
     */
    public ?float $duration = null;

    /**
     * Optional. Timestamp in seconds of the frame that will be used as the static cover for the story. Defaults to 0.0.
     */
    public ?float $cover_frame_timestamp = null;

    /**
     * Optional. Pass True if the video has no sound
     */
    public ?bool $is_animation = null;

    public function isLocal(): bool
    {
        return $this->video instanceof InputFile;
    }

    public function getFilename(): string
    {
        return $this->video->getFilename();
    }

    public function getResource()
    {
        return $this->video->getResource();
    }

    public function __construct(InputFile|string $video, ?float $duration = null, ?float $cover_frame_timestamp = null, ?bool $is_animation = null)
    {
        parent::__construct();
        $this->video = $video;
        $this->duration = $duration;
        $this->cover_frame_timestamp = $cover_frame_timestamp;
        $this->is_animation = $is_animation;
    }
}
