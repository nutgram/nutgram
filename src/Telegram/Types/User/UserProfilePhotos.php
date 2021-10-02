<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represent a user's profile pictures.
 * @see https://core.telegram.org/bots/api#userprofilephotos
 */
class UserProfilePhotos
{
    /**
     * Total number of profile pictures the target user has
     * @var int $total_count
     */
    public $total_count;

    /**
     * Requested profile pictures (in up to 4 sizes each)
     * @var PhotoSize[][] $photos
     */
    public $photos;
}
