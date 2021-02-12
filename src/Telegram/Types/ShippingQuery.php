<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains information about an incoming shipping query.
 * @see https://core.telegram.org/bots/api#shippingquery
 */
class ShippingQuery
{
    /**
     * Unique query identifier
     * @var string
     */
    public string $id;

    /**
     * User who sent the query
     * @var User
     */
    public User $from;

    /**
     * Bot specified invoice payload
     * @var string
     */
    public string $invoice_payload;

    /**
     * User specified shipping address
     * @var ShippingAddress
     */
    public ShippingAddress $shipping_address;
}
