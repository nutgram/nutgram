<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

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
    public ?string $parse_mode = null;

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
     */
    public ?bool $disable_web_page_preview = null;

    public function __construct(
        string $message_text,
        ?string $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
    ) {
        parent::__construct();
        $this->message_text = $message_text;
        $this->parse_mode = $parse_mode;
        $this->entities = $entities;
        $this->disable_web_page_preview = $disable_web_page_preview;
    }

    public static function make(
        string $message_text,
        ?string $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
    ): self {
        return new self(
            message_text: $message_text,
            parse_mode: $parse_mode,
            entities: $entities,
            disable_web_page_preview: $disable_web_page_preview,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'message_text' => $this->message_text,
            'parse_mode' => $this->parse_mode,
            'entities' => $this->entities,
            'disable_web_page_preview' => $this->disable_web_page_preview,
        ]);
    }
}
