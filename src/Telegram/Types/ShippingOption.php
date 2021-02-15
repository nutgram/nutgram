<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption
{
    /**
     * Shipping option identifier
     * @var string $id
     */
    public $id;
    
    /**
     * Option title
     * @var string $title
     */
    public $title;
    
    /**
     * List of price portions
     * @var LabeledPrice[] $prices
     */
    public $prices;
}
