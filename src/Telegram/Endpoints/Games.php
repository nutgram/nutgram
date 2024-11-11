<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Game\GameHighScore;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\ReplyParameters;

/**
 * Trait Games
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Games
{
    /**
     * Use this method to send a game.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendgame
     * @param string $game_short_name Short name of the game, serves as the unique identifier for the game. Set up your games via {@see https://t.me/botfather @BotFather}.
     * @param int|null $chat_id Unique identifier for the target chat
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}. If empty, one 'Play game_title' button will be shown. If not empty, the first button must launch the game.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendGame(
        string $game_short_name,
        ?int $chat_id = null,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $parameters = compact(
            'chat_id',
            'message_thread_id',
            'game_short_name',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to set the score of the specified user in a game message.
     * On success, if the message is not an inline message, the {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
     * @see https://core.telegram.org/bots/api#setgamescore
     * @param int $score New score, must be non-negative
     * @param int|null $user_id User identifier
     * @param bool|null $force Pass True if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters
     * @param bool|null $disable_edit_message Pass True if the game message should not be automatically edited to include the current scoreboard
     * @param int|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the sent message
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @return Message|bool|null
     */
    public function setGameScore(
        int $score,
        ?int $user_id = null,
        ?bool $force = null,
        ?bool $disable_edit_message = null,
        ?int $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'user_id',
            'score',
            'force',
            'disable_edit_message',
            'chat_id',
            'message_id',
            'inline_message_id'
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to get data for high score tables.
     * Will return the score of the specified user and several of their neighbors in a game.
     * Returns an Array of {@see https://core.telegram.org/bots/api#gamehighscore GameHighScore} objects.
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param int|null $user_id Target user id
     * @param int|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the sent message
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @return GameHighScore[]|null
     */
    public function getGameHighScores(
        ?int $user_id = null,
        ?int $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
    ): ?array {
        $parameters = compact(
            'user_id',
            'chat_id',
            'message_id',
            'inline_message_id'
        );

        $this->setChatMessageOrInlineMessageId($parameters);
        return $this->requestJson(__FUNCTION__, $parameters, GameHighScore::class);
    }
}
