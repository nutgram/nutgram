<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

/**
 * This object represents a phone contact.
 * @see https://core.telegram.org/bots/api#contact
 */
class Contact
{
    /**
     * Contact's phone number
     * @var string $phone_number
     */
    public $phone_number;

    /**
     * Contact's first name
     * @var string $first_name
     */
    public $first_name;

    /**
     * Optional. Contact's last name
     * @var string $last_name
     */
    public $last_name;

    /**
     * Optional. Contact's user identifier in Telegram
     * @var int $user_id
     */
    public $user_id;

    /**
     * Optional. Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}
     * @var string $vcard
     */
    public $vcard;
}
