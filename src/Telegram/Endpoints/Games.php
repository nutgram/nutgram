<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Game\GameHighScore;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

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
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}. If empty, one 'Play game_title' button will be shown. If not empty, the first button must launch the game.
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
        ?InlineKeyboardMarkup $reply_markup = null,
    ): ?Message
    {
        // TODO: $chat_id ??= $this->chatId();
        // TODO: $parameters = array_filter(compact('chat_id', 'message_thread_id', 'game_short_name', 'disable_notification', 'protect_content', 'reply_to_message_id', 'allow_sending_without_reply', 'reply_markup'));

        $chat_id = $this->chatId();
        $required = compact('game_short_name', 'chat_id');
        return $this->requestJson(__FUNCTION__, [...$required, ...$opt], Message::class);
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
    ): Message|bool|null
    {
        // TODO: $chat_id ??= $this->chatId();
        // TODO: $user_id ??= $this->userId();
        // TODO: $parameters = array_filter(compact('user_id', 'score', 'force', 'disable_edit_message', 'chat_id', 'message_id', 'inline_message_id'));

        $user_id = $this->userId();
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $required = compact('score', 'user_id');
        return $this->requestJson(__FUNCTION__, [...$target, ...$required, ...$opt]);
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
    ): ?array
    {
        // TODO: $chat_id ??= $this->chatId();
        // TODO: $user_id ??= $this->userId();
        // TODO: $parameters = array_filter(compact('user_id', 'chat_id', 'message_id', 'inline_message_id'));

        $user_id = $this->userId();
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $required = compact('user_id');
        return $this->requestJson(__FUNCTION__, [...$target, ...$required, ...$opt], GameHighScore::class);
    }
}
