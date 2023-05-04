<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a shipping address.
 * @see https://core.telegram.org/bots/api#shippingaddress
 */
class ShippingAddress extends BaseType
{
    /** Two-letter ISO 3166-1 alpha-2 country code */
    public string $country_code;

    /** State, if applicable */
    public string $state;

    /** City */
    public string $city;

    /** First line for the address */
    public string $street_line1;

    /** Second line for the address */
    public string $street_line2;

    /** Address post code */
    public string $post_code;
}
