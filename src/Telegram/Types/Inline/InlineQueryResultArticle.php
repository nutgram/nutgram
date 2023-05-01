<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputInvoiceMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a link to an article or web page.
 * @see https://core.telegram.org/bots/api#inlinequeryresultarticle
 */
class InlineQueryResultArticle extends InlineQueryResult
{
    /** Type of the result, must be article */
    public string $type;

    /** Unique identifier for this result, 1-64 Bytes */
    public string $id;

    /** Title of the result */
    public string $title;

    /** Content of the message to be sent */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|InputInvoiceMessageContent $input_message_content;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * URL of the result
     */
    public ?string $url = null;

    /**
     * Optional.
     * Pass True if you don't want the URL to be shown in the message
     */
    public ?bool $hide_url = null;

    /**
     * Optional.
     * Short description of the result
     */
    public ?string $description = null;

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
