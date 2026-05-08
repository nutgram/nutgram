<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Location\Venue;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\Document;
use SergiX44\Nutgram\Telegram\Types\Media\LivePhoto;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Media\Video;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;

/**
 * At most one of the optional fields can be present in any given object.
 * @see https://core.telegram.org/bots/api#pollmedia
 */
class PollMedia extends BaseType
{
    /**
     * Optional. Media is an animation, information about the animation
     */
    public ?Animation $animation = null;

    /**
     * Optional. Media is an audio file, information about the file; currently, can't be received in a poll option
     */
    public ?Audio $audio = null;

    /**
     * Optional. Media is a general file, information about the file; currently, can't be received in a poll option
     */
    public ?Document $document = null;

    /**
     * Optional. Media is a live photo, information about the live photo
     */
    public ?LivePhoto $live_photo = null;

    /**
     * Optional. Media is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * Optional. Media is a photo, available sizes of the photo
     * @var PhotoSize[]|null
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;

    /**
     * Optional. Media is a sticker, information about the sticker; currently, for poll options only
     */
    public ?Sticker $sticker = null;

    /**
     * Optional. Media is a venue, information about the venue
     */
    public ?Venue $venue = null;

    /**
     * Optional. Media is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * Check if the media is of a specific type
     * @param class-string<BaseType> $type
     * @return bool
     */
    public function is(string $type): bool
    {
        $currentType = match(true) {
            $this->animation !== null => Animation::class,
            $this->audio !== null => Audio::class,
            $this->document !== null => Document::class,
            $this->live_photo !== null => LivePhoto::class,
            $this->location !== null => Location::class,
            $this->photo !== null => PhotoSize::class,
            $this->sticker !== null => Sticker::class,
            $this->venue !== null => Venue::class,
            $this->video !== null => Video::class,
        };

        return $currentType === $type;
    }
}
