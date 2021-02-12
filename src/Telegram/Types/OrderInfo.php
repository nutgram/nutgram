<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents information about an order.
 * @see https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo
{
    /**
     * Optional. User name
     * @var string
     */
    public string $name;

    /**
     * Optional. User's phone number
     * @var string
     */
    public string $phone_number;

    /**
     * Optional. User email
     * @var string
     */
    public string $email;

    /**
     * Optional. User shipping address
     * @var ShippingAddress
     */
    public ShippingAddress $shipping_address;
}
