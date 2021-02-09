<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a contact message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputcontactmessagecontent
 */
class InputContactMessageContent
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
     * Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     * @var string
     */
    public string $vcard;
}
