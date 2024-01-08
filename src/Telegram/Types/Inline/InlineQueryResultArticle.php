<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a link to an article or web page.
 * @see https://core.telegram.org/bots/api#inlinequeryresultarticle
 */
class InlineQueryResultArticle extends InlineQueryResult
{
    /** Type of the result, must be article */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::ARTICLE;

    /** Unique identifier for this result, 1-64 Bytes */
    public string $id;

    /** Title of the result */
    public string $title;

    /** Content of the message to be sent */
    public InputMessageContent $input_message_content;

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

    public function __construct(
        string $id,
        string $title,
        InputMessageContent $input_message_content,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $url = null,
        ?bool $hide_url = null,
        ?string $description = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->input_message_content = $input_message_content;
        $this->reply_markup = $reply_markup;
        $this->url = $url;
        $this->hide_url = $hide_url;
        $this->description = $description;
        $this->thumbnail_url = $thumbnail_url;
        $this->thumbnail_width = $thumbnail_width;
        $this->thumbnail_height = $thumbnail_height;
    }

    public static function make(
        string $id,
        string $title,
        InputMessageContent $input_message_content,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $url = null,
        ?bool $hide_url = null,
        ?string $description = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ): self {
        return new self(
            id: $id,
            title: $title,
            input_message_content: $input_message_content,
            reply_markup: $reply_markup,
            url: $url,
            hide_url: $hide_url,
            description: $description,
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
            'title' => $this->title,
            'input_message_content' => $this->input_message_content,
            'reply_markup' => $this->reply_markup,
            'url' => $this->url,
            'hide_url' => $this->hide_url,
            'description' => $this->description,
            'thumbnail_url' => $this->thumbnail_url,
            'thumbnail_width' => $this->thumbnail_width,
            'thumbnail_height' => $this->thumbnail_height,
        ]);
    }
}
