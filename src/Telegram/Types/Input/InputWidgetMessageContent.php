<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a m
 * essage with an {@see https://core.telegram.org/bots/widgets HTML widget} to be sent as the result of an inline query.
 * Currently, widgets can't be sent in response to inline queries in the production environment.
 * @see https://core.telegram.org/bots/api#inputwidgetmessagecontent
 */
#[SkipConstructor]
class InputWidgetMessageContent extends InputMessageContent
{
    /**
     * HTML code of the widget, 1-32768 bytes.
     * The code must not exceed 4096 bytes when compressed by zlib with the maximum compression level.
     */
    public string $html;

    /**
     * Optional.
     * Width of the widget in logical pixels;
     * omit if the widget must occupy the whole width of the message bubble.
     * The width is clamped by the app to the range from 200 to the maximum width of the message bubble.
     */
    public ?int $width = null;

    /**
     * Optional.
     * Height of the widget in logical pixels;
     * omit if the height of the widget isn't fixed.
     * The height is clamped by the app to the range 50-600.
     */
    public ?int $height = null;

    /**
     * Optional.
     * Public data of the widget, 0-1024 bytes, which will be available wherever the widget is shown.
     * If the widget is shared, then all messages with it will have the same public data.
     */
    public ?string $public_data = null;

    /**
     * Optional.
     * Data of the widget, which is specific to the message, 0-1024 bytes
     */
    public ?string $chat_data = null;

    /**
     * Optional.
     * Widget caption, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the widget caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. Pass True if the caption must be shown above the widget
     */
    public ?bool $show_caption_above_media = null;

    /**
     * Optional. Pass True to allow the widget to send queries to the bot
     */
    public ?bool $allow_queries = null;

    /**
     * Optional. Pass True to create a shared widget.
     * Each message sent from the result creates a separate shared widget,
     * whose identifier is received by the bot only in the field widget_id of queries from the widget.
     * To send an existing shared widget in response to an inline query,
     * use {@see https://core.telegram.org/bots/api#inputsharedwidgetmessagecontent InputSharedWidgetMessageContent} instead.
     */
    public ?bool $is_shared = null;

    /**
     * @param string $html
     * @param int|null $width
     * @param int|null $height
     * @param string|null $public_data
     * @param string|null $chat_data
     * @param string|null $caption
     * @param ParseMode|string|null $parse_mode
     * @param MessageEntity[]|null $caption_entities
     * @param bool|null $show_caption_above_media
     * @param bool|null $allow_queries
     * @param bool|null $is_shared
     */
    public function __construct(
        string $html,
        ?int $width = null,
        ?int $height = null,
        ?string $public_data = null,
        ?string $chat_data = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $allow_queries = null,
        ?bool $is_shared = null,
    ) {
        parent::__construct();
        $this->html = $html;
        $this->width = $width;
        $this->height = $height;
        $this->public_data = $public_data;
        $this->chat_data = $chat_data;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->show_caption_above_media = $show_caption_above_media;
        $this->allow_queries = $allow_queries;
        $this->is_shared = $is_shared;
    }


    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
