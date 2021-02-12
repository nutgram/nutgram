<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a shipping address.
 * @see https://core.telegram.org/bots/api#shippingaddress
 */
class ShippingAddress
{
    /**
     * ISO 3166-1 alpha-2 country code
     * @var string
     */
    public string $country_code;

    /**
     * State, if applicable
     * @var string
     */
    public string $state;

    /**
     * City
     * @var string
     */
    public string $city;

    /**
     * First line for the address
     * @var string
     */
    public string $street_line1;

    /**
     * Second line for the address
     * @var string
     */
    public string $street_line2;

    /**
     * Address post code
     * @var string
     */
    public string $post_code;
}
