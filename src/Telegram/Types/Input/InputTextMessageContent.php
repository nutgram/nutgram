<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a text message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputtextmessagecontent
 */
class InputTextMessageContent extends BaseType
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
}
