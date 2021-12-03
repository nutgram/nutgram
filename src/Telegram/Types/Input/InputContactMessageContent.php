<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a contact message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputcontactmessagecontent
 */
class InputContactMessageContent extends BaseType
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
     * Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     */
    public ?string $vcard = null;
}
