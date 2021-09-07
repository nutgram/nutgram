<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a link to an article or web page.
 * @see https://core.telegram.org/bots/api#inlinequeryresultarticle
 */
class InlineQueryResultArticle
{
    /**
     * Type of the result, must be article
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string $id
     */
    public $id;

    /**
     * Title of the result
     * @var string $title
     */
    public $title;

    /**
     * Content of the message to be sent
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;

    /**
     * Optional. URL of the result
     * @var string $url
     */
    public $url;

    /**
     * Optional. Pass True, if you don't want the URL to be shown in the message
     * @var bool $hide_url
     */
    public $hide_url;

    /**
     * Optional. Short description of the result
     * @var string $description
     */
    public $description;

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
