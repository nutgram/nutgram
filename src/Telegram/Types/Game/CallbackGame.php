<?php

namespace SergiX44\Nutgram\Telegram\Types\Game;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A placeholder, currently holds no information.
 * Use {@see https://t.me/botfather BotFather} to set up your game.
 * @see https://core.telegram.org/bots/api#callbackgame
 */
class CallbackGame extends BaseType
{
    public static function make(): self
    {
        return new self();
    }
}
