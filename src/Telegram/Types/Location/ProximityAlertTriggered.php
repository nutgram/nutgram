<?php


namespace SergiX44\Nutgram\Telegram\Types\Location;

use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents the content of a service message, sent whenever a user in the chat
 * triggers a proximity alert set by another user.
 * @see https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered
{
    /**
     * User that triggered the alert
     * @var User $traveler
     */
    public $traveler;

    /**
     * User that set the alert
     * @var User $watcher
     */
    public $watcher;

    /**
     * The distance between the users
     * @var int $distance
     */
    public $distance;
}
