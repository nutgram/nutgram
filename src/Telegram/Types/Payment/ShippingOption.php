<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption extends BaseType implements JsonSerializable
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

    public static function make(string $id, string $title, array $prices): self
    {
        return new self($id, $title, $prices);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'prices' => $this->prices
        ];
    }
}
