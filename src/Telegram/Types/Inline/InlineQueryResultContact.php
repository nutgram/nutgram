<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputInvoiceMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a contact with a phone number.
 * By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcontact
 */
class InlineQueryResultContact extends InlineQueryResult
{
    /** Type of the result, must be contact */
    public string $type;

    /** Unique identifier for this result, 1-64 Bytes */
    public string $id;

    /** Contact's phone number */
    public string $phone_number;

    /** Contact's first name */
    public string $first_name;

    /**
     * Optional.
     * Contact's last name
     */
    public ?string $last_name = null;

    /**
     * Optional.
     * Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}, 0-2048 bytes
     */
    public ?string $vcard = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the contact
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|InputInvoiceMessageContent|null $input_message_content = null;

    /**
     * Optional.
     * Url of the thumbnail for the result
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional.
     * Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional.
     * Thumbnail height
     */
    public ?int $thumbnail_height = null;
}
