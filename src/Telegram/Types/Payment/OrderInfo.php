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
     */
    public ?string $name = null;

    /**
     * Optional. User's phone number
     */
    public ?string $phone_number = null;

    /**
     * Optional. User email
     */
    public ?string $email = null;

    /**
     * Optional. User shipping address
     */
    public ?ShippingAddress $shipping_address = null;
}
