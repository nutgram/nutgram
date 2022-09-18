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
     * @param  string  $game_short_name Short name of the game, serves as the unique identifier for the game. Set up
     *     your games via {@see https://t.me/botfather Botfather}.
     * @param  array{
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @return Message|null
     */
    public function sendGame(string $game_short_name, array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('game_short_name', 'chat_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to set the score of the specified user in a game.
     * On success, if the message was sent by the bot,
     * returns the edited {@see https://core.telegram.org/bots/api#message Message}, otherwise returns True.
     * Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
     * @see https://core.telegram.org/bots/api#setgamescore
     * @param  int  $score New score, must be non-negative
     * @param  array{
     *     force?:bool,
     *     disable_edit_message?:bool,
     *     chat_id?:int,
     *     message_id?:int,
     *     inline_message_id?:string
     * }  $opt
     * @return bool|null
     */
    public function setGameScore(int $score, array $opt = []): ?bool
    {
        $user_id = $this->userId();
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $required = compact('score', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($target, $required, $opt));
    }

    /**
     * Use this method to get data for high score tables.
     * Will return the score of the specified user and several of their neighbors in a game.
     * On success, returns an Array of {@see https://core.telegram.org/bots/api#gamehighscore GameHighScore} objects.
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param  array{
     *     chat_id?:int,
     *     message_id?:int,
     *     inline_message_id?:string
     * }  $opt
     * @return array|null
     */
    public function getGameHighScores(array $opt = []): ?array
    {
        $user_id = $this->userId();
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $required = compact('user_id');
        return $this->requestJson(__FUNCTION__, array_merge($target, $required, $opt), GameHighScore::class);
    }
}
