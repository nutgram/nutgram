<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the physical address of a location.
 * @see https://core.telegram.org/bots/api#locationaddress
 */
#[SkipConstructor]
class LocationAddress extends BaseType
{
    /**
     * The two-letter ISO 3166-1 alpha-2 country code of the country where the location is located
     */
    public string $country_code;

    /**
     * Optional. State of the location
     */
    public ?string $state = null;

    /**
     * Optional. City of the location
     */
    public ?string $city = null;

    /**
     * Optional. Street address of the location
     */
    public ?string $street = null;

    public function __construct(string $country_code, ?string $state = null, ?string $city = null, ?string $street = null)
    {
        parent::__construct();
        $this->country_code = $country_code;
        $this->state = $state;
        $this->city = $city;
        $this->street = $street;
    }
}
