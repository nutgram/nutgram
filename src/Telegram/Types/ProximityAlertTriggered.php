<?php


namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents the content of a service message, sent whenever a user in the chat
 * triggers a proximity alert set by another user.
 * @see https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered
{
    /**
     * User that triggered the alert
     * @var User
     */
    public User $traveler;

    /**
     * User that set the alert
     * @var User
     */
    public User $watcher;

    /**
     * The distance between the users
     * @var int
     */
    public int $distance;
}
