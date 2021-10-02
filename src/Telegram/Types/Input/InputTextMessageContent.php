<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a text message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputtextmessagecontent
 */
class InputTextMessageContent
{
    /**
     * Text of the message to be sent, 1-4096 characters
     * @var string $message_text
     */
    public $message_text;

    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     * @var string $parse_mode
     */
    public $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    public $entities;

    /**
     * Optional. Disables link previews for links in the sent message
     * @var string $disable_web_page_preview
     */
    public $disable_web_page_preview;
}
