<?php


namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation
{
    /**
     * The location to which the supergroup is connected. Can't be a live location.
     * @var Location
     */
    public Location $location;

    /**
     * Location address; 1-64 characters, as defined by the chat owner
     * @var string
     */
    public string $address;
}
