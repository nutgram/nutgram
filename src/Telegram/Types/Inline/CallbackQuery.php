<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an incoming callback query from a callback button
 * in an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}
 * or in a {@see https://core.telegram.org/bots/api#richmessage rich message}.
 * If the button that originated the query belongs to a message sent by the bot, the field message will be present, unless the field inline_message_id is used instead as specified by the parameter callback_query_mode of the method setMySettings.
 * If the button belongs to a message sent via the bot (in inline mode), the field inline_message_id will be present.
 * Exactly one of the fields data or game_short_name will be present.
 *
 * > NOTE: After the user presses a callback button, Telegram clients will display a progress bar until you call {@see https://core.telegram.org/bots/api#answercallbackquery answerCallbackQuery}.
 * > It is, therefore, necessary to react by calling answerCallbackQuery even if no notification to the user is needed (e.g., without specifying any of the optional parameters).
 *
 * @see https://core.telegram.org/bots/api#callbackquery
 */
class CallbackQuery extends BaseType
{
    /** Unique identifier for this query */
    public string $id;

    /** Sender */
    public User $from;

    /**
     * Optional.
     * Message with the callback button that originated the query.
     * Note that message content and message date will not be available if the message is too old
     */
    public ?Message $message = null;

    /**
     * Optional.
     * Identifier of the message sent via the bot in inline mode, that originated the query.
     * Can also be present for messages sent by the bot, depending on the parameter callback_query_mode
     * of the method {@see https://core.telegram.org/bots/api#setmysettings setMySettings}.
     */
    public ?string $inline_message_id = null;

    /**
     * Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent.
     * Useful for high scores in {@see https://core.telegram.org/bots/api#games games}.
     */
    public string $chat_instance;

    /**
     * Optional.
     * Data associated with the callback button.
     * Be aware that the message originated the query can contain no callback buttons with this data.
     */
    public ?string $data = null;

    /**
     * Optional.
     * Short name of a {@see https://core.telegram.org/bots/api#games Game} to be returned, serves as the unique identifier for the game
     */
    public ?string $game_short_name = null;
}
