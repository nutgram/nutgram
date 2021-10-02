<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

/**
 * This object represents information about an order.
 * @see https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo
{
    /**
     * Optional. User name
     * @var string $name
     */
    public $name;

    /**
     * Optional. User's phone number
     * @var string $phone_number
     */
    public $phone_number;

    /**
     * Optional. User email
     * @var string $email
     */
    public $email;

    /**
     * Optional. User shipping address
     * @var ShippingAddress $shipping_address
     */
    public $shipping_address;
}
