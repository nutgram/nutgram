<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a contact with a phone number.
 * By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcontact
 */
class InlineQueryResultContact extends InlineQueryResult
{
    /** Type of the result, must be contact */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::CONTACT;

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
    public ?InputMessageContent $input_message_content = null;

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

    public function __construct(
        string $id,
        string $phone_number,
        string $first_name,
        ?string $last_name = null,
        ?string $vcard = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->phone_number = $phone_number;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->vcard = $vcard;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->thumbnail_url = $thumbnail_url;
        $this->thumbnail_width = $thumbnail_width;
        $this->thumbnail_height = $thumbnail_height;
    }

    public static function make(
        string $id,
        string $phone_number,
        string $first_name,
        ?string $last_name = null,
        ?string $vcard = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ): self {
        return new self(
            id: $id,
            phone_number: $phone_number,
            first_name: $first_name,
            last_name: $last_name,
            vcard: $vcard,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
            thumbnail_url: $thumbnail_url,
            thumbnail_width: $thumbnail_width,
            thumbnail_height: $thumbnail_height,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'vcard' => $this->vcard,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'thumb_url' => $this->thumbnail_url,
            'thumb_width' => $this->thumbnail_width,
            'thumb_height' => $this->thumbnail_height,
        ]);
    }
}
