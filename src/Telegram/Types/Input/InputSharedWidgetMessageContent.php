<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a message with a shared widget to be sent as the result of an inline query.
 * Currently, widgets can't be sent in response to inline queries in the production environment.
 * @see https://core.telegram.org/bots/api#inputwidgetmessagecontent
 */
#[SkipConstructor]
class InputSharedWidgetMessageContent extends InputMessageContent
{
    /**
     * Unique identifier of the shared widget created by the bot
     */
    public string $widget_id;

    /**
     * Optional. Data of the widget, which is specific to the message, 0-1024 bytes
     */
    public ?string $chat_data = null;

    /**
     * Optional. Widget caption, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional. Mode for parsing entities in the widget caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. Pass True if the caption must be shown above the widget
     */
    public ?bool $show_caption_above_media = null;

    /**
     * @param string $widget_id
     * @param string|null $chat_data
     * @param string|null $caption
     * @param ParseMode|string|null $parse_mode
     * @param MessageEntity[]|null $caption_entities
     * @param bool|null $show_caption_above_media
     */
    public function __construct(
        string $widget_id,
        ?string $chat_data = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $show_caption_above_media = null,
    ) {
        parent::__construct();
        $this->widget_id = $widget_id;
        $this->chat_data = $chat_data;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->show_caption_above_media = $show_caption_above_media;
    }


    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
