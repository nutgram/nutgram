<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a phone contact.
 * @see https://core.telegram.org/bots/api#contact
 */
class Contact extends BaseType
{
    /**
     * Contact's phone number
     */
    public string $phone_number;

    /**
     * Contact's first name
     */
    public string $first_name;

    /**
     * Optional. Contact's last name
     */
    public ?string $last_name = null;

    /**
     * Optional. Contact's user identifier in Telegram
     */
    public ?int $user_id = null;

    /**
     * Optional. Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}
     */
    public ?string $vcard = null;
}
