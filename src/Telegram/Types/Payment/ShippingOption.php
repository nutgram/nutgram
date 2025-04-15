<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
#[OverrideConstructor('bindToInstance')]
class ShippingOption extends BaseType
{
    /** Shipping option identifier */
    public string $id;

    /** Option title */
    public string $title;

    /**
     * List of price portions
     * @var LabeledPrice[] $prices
     */
    #[ArrayType(LabeledPrice::class)]
    public array $prices;

    public function __construct(string $id, string $title, array $prices)
    {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->prices = $prices;
    }
}
