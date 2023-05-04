<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents the content of a service message, sent whenever a user in the chat triggers a proximity alert set by another user.
 * @see https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered extends BaseType
{
    /** User that triggered the alert */
    public User $traveler;

    /** User that set the alert */
    public User $watcher;

    /** The distance between the users */
    public int $distance;
}
