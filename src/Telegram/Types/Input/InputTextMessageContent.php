<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a text message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputtextmessagecontent
 */
class InputTextMessageContent extends InputMessageContent
{
    /** Text of the message to be sent, 1-4096 characters */
    public string $message_text;

    /**
     * Optional.
     * Mode for parsing entities in the message text.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in message text, which can be specified instead of parse_mode
     * @var MessageEntity[] $entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;

    /**
     * Optional.
     * Disables link previews for links in the sent message
     * @deprecated Use $link_preview_options instead
     */
    public ?bool $disable_web_page_preview = null;

    /**
     * Optional. Link preview generation options for the message
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    public static function make(
        string $message_text,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
    ): self {
        $instance = new self;
        $instance->message_text = $message_text;
        $instance->parse_mode = $parse_mode;
        $instance->entities = $entities;
        $instance->disable_web_page_preview = $disable_web_page_preview;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'message_text' => $this->message_text,
            'parse_mode' => $this->parse_mode,
            'entities' => $this->entities,
            'disable_web_page_preview' => $this->disable_web_page_preview,
            'link_preview_options' => $this->link_preview_options,
        ]);
    }
}
