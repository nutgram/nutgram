<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\GameHighScore;
use SergiX44\Nutgram\Telegram\Types\Message;

/**
 * Trait Games
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Games
{
    /**
     * @param  string  $game_short_name
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
     * @param  int  $score
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
     * @param  array|null  $opt
     * @return array|null
     */
    public function getGameHighScores(?array $opt = []): ?array
    {
        return $this->requestJson(__FUNCTION__, array_merge(['user_id' => $this->userId()], $opt), GameHighScore::class);
    }
}