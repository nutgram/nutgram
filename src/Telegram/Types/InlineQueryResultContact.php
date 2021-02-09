<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a contact with a phone number. By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcontact
 */
class InlineQueryResultContact
{
    /**
     * Type of the result, must be contact
     * @var string
     */
    public string $type;
    
    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string
     */
    public string $id;
    
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
     * $vcard Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     * @var string
     */
    public string $vcard;
    
    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;
    
    /**
     * Optional. Content of the message to be sent instead of the contact
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
    
    /**
     * Optional. Url of the thumbnail for the result
     * @var string
     */
    public string $thumb_url;
    
    /**
     * Optional. Thumbnail width
     * @var int
     */
    public int $thumb_width;
    
    /**
     * Optional. Thumbnail height
     * @var int
     */
    public int $thumb_height;
}
