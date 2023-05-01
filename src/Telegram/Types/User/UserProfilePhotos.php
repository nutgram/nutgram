<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represent a user's profile pictures.
 * @see https://core.telegram.org/bots/api#userprofilephotos
 */
class UserProfilePhotos extends BaseType
{
    /** Total number of profile pictures the target user has */
    public int $total_count;

    /**
     * Requested profile pictures (in up to 4 sizes each)
     * @var PhotoSize[][] $photos
     */
    #[ArrayType(PhotoSize::class, depth: 2)]
    public array $photos;
}
