<?php

namespace SergiX44\Nutgram\Telegram\Types\Game;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents one row of the high scores table for a game.
 * @see https://core.telegram.org/bots/api#gamehighscore
 */
class GameHighScore extends BaseType
{
    /** Position in high score table for the game */
    public int $position;

    /** User */
    public User $user;

    /** Score */
    public int $score;
}
