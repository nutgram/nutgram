<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represent a list of gifts.
 * @see https://core.telegram.org/bots/api#gifts
 */
class Gifts extends BaseType
{
    /**
     * The list of gifts
     * @var Gift[] $gifts
     */
    #[ArrayType(Gift::class)]
    public array $gifts;
}
