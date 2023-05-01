<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about an incoming shipping query.
 * @see https://core.telegram.org/bots/api#shippingquery
 */
class ShippingQuery extends BaseType
{
    /** Unique query identifier */
    public string $id;

    /** User who sent the query */
    public User $from;

    /** Bot specified invoice payload */
    public string $invoice_payload;

    /** User specified shipping address */
    public ShippingAddress $shipping_address;
}
