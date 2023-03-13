<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\Alias;
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
class InlineQueryResultContact extends InlineQueryResult
{
    /**
     * Type of the result, must be contact
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     */
    public string $id;

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

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional. Content of the message to be sent instead of the contact
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|null $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional. Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional. Thumbnail height
     */
    public ?int $thumbnail_height = null;

    /**
     * Optional. Url of the thumbnail for the result
     * @deprecated Use thumbnail_url
     */
    #[Alias('thumbnail_url')]
    public ?string $thumb_url = null;

    /**
     * Optional. Thumbnail width
     * @deprecated Use thumbnail_width
     */
    #[Alias('thumbnail_width')]
    public ?int $thumb_width = null;

    /**
     * Optional. Thumbnail height
     * @deprecated Use thumbnail_height
     */
    #[Alias('thumbnail_height')]
    public ?int $thumb_height = null;
}
