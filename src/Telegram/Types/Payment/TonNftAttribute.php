<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an attribute of an NFT in the TON blockchain.
 * @see https://core.telegram.org/bots/api#tonnftattribute
 */
class TonNftAttribute extends BaseType
{
    /**
     * Trait type of the attribute
     */
    public string $trait_type;

    /**
     * Value of the attribute
     */
    public string $value;
}
