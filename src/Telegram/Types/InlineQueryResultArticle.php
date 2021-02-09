<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to an article or web page.
 * @see https://core.telegram.org/bots/api#inlinequeryresultarticle
 */
class InlineQueryResultArticle
{
    /**
     * Type of the result, must be article
     * @var string
     */
    public string $type;
    
    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string
     */
    public string $id;
    
    /**
     * Title of the result
     * @var string
     */
    public string $title;
    
    /**
     * Content of the message to be sent
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
    
    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;
    
    /**
     * Optional. URL of the result
     * @var string
     */
    public string $url;
    
    /**
     * Optional. Pass True, if you don't want the URL to be shown in the message
     * @var bool
     */
    public bool $hide_url;
    
    /**
     * Optional. Short description of the result
     * @var string
     */
    public string $description;
    
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
