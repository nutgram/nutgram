<?php


namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\Location\Location;

/**
 * Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation
{
    /**
     * The location to which the supergroup is connected. Can't be a live location.
     * @var Location $location
     */
    public $location;

    /**
     * Location address; 1-64 characters, as defined by the chat owner
     * @var string $address
     */
    public $address;
}
