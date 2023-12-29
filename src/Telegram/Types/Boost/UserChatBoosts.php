<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a list of boosts added to a chat by a user.
 * @see https://core.telegram.org/bots/api#userchatboosts
 */
class UserChatBoosts extends BaseType
{
    /**
     * The list of boosts added to the chat by the user
     * @var ChatBoost[]
     */
    #[ArrayType(ChatBoost::class)]
    public array $boosts;
}
