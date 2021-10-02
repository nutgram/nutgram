<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string $id
     */
    public $id;

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
     * $vcard Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     * @var string $vcard
     */
    public $vcard;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the contact
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     * @var string $thumb_url
     */
    public $thumb_url;

    /**
     * Optional. Thumbnail width
     * @var int $thumb_width
     */
    public $thumb_width;

    /**
     * Optional. Thumbnail height
     * @var int $thumb_height
     */
    public $thumb_height;
}
