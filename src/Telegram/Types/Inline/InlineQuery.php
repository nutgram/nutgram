<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an incoming inline query.
 * When the user sends an empty query, your bot could return some default or trending results.
 * @see https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery extends BaseType
{
    /** Unique identifier for this query */
    public string $id;

    /** Sender */
    public User $from;

    /** Text of the query (up to 256 characters) */
    public string $query;

    /** Offset of the results to be returned, can be controlled by the bot */
    public string $offset;

    /**
     * Optional.
     * Type of the chat from which the inline query was sent.
     * Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”.
     * The chat type should be always known for requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
     */
    #[EnumOrScalar]
    public ChatType|string|null $chat_type = null;

    /**
     * Optional.
     * Sender location, only for bots that request user location
     */
    public ?Location $location = null;

    public function isSender(): bool
    {
        return $this->chat_type === ChatType::SENDER;
    }

    public function isPrivate(): bool
    {
        return $this->chat_type === ChatType::PRIVATE;
    }

    public function isGroup(): bool
    {
        return $this->chat_type === ChatType::GROUP;
    }

    public function isSupergroup(): bool
    {
        return $this->chat_type === ChatType::SUPERGROUP;
    }

    public function isChannel(): bool
    {
        return $this->chat_type === ChatType::CHANNEL;
    }
}
