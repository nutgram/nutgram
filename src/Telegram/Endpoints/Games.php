<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Game\GameHighScore;
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
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendGame(string $game_short_name, ?array $opt = []): ?Message
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
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setGameScore(int $score, ?array $opt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('score', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to get data for high score tables.
     * Will return the score of the specified user and several of their neighbors in a game.
     * On success, returns an Array of {@see https://core.telegram.org/bots/api#gamehighscore GameHighScore} objects.
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param  array|null  $opt
     * @return array|null
     */
    public function getGameHighScores(?array $opt = []): ?array
    {
        return $this->requestJson(__FUNCTION__, array_merge(['user_id' => $this->userId()], $opt), GameHighScore::class);
    }
}
