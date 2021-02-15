<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one row of the high scores table for a game.
 * @see https://core.telegram.org/bots/api#gamehighscore
 */
class GameHighScore
{
    /**
     * Position in high score table for the game
     * @var int $position
     */
    public $position;
    
    /**
     * User
     * @var User $user
     */
    public $user;
    
    /**
     * Score
     * @var int $score
     */
    public $score;
}
