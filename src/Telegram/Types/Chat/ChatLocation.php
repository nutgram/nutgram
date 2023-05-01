<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;

/**
 * Represents a location to which a chat is connected.
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation extends BaseType
{
    /**
     * The location to which the supergroup is connected.
     * Can't be a live location.
     */
    public Location $location;

    /**
     * Location address;
     * 1-64 characters, as defined by the chat owner
     */
    public string $address;
}
