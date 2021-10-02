<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

/**
 * This object represents a shipping address.
 * @see https://core.telegram.org/bots/api#shippingaddress
 */
class ShippingAddress
{
    /**
     * ISO 3166-1 alpha-2 country code
     * @var string $country_code
     */
    public $country_code;

    /**
     * State, if applicable
     * @var string $state
     */
    public $state;

    /**
     * City
     * @var string $city
     */
    public $city;

    /**
     * First line for the address
     * @var string $street_line1
     */
    public $street_line1;

    /**
     * Second line for the address
     * @var string $street_line2
     */
    public $street_line2;

    /**
     * Address post code
     * @var string $post_code
     */
    public $post_code;
}
