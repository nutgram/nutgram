<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a phone contact.
 * @see https://core.telegram.org/bots/api#contact
 */
class Contact
{
    /**
     * Contact's phone number
     * @var string
     */
    public string $phone_number;
    
    /**
     * Contact's first name
     * @var string
     */
    public string $first_name;
    
    /**
     * Optional. Contact's last name
     * @var string
     */
    public string $last_name;
    
    /**
     * Optional. Contact's user identifier in Telegram
     * @var int
     */
    public int $user_id;
    
    /**
     * Optional. Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}
     * @var string
     */
    public string $vcard;
}
