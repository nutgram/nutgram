<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents the audios displayed on a user's profile.
 * @see https://core.telegram.org/bots/api#userprofileaudios
 */
class UserProfileAudios extends BaseType
{
    /**
     * Total number of profile audios for the target user
     */
    public int $total_count;

    /**
     * Requested profile audios
     * @var Audio[]
     */
    #[ArrayType(Audio::class)]
    public array $audios;
}
