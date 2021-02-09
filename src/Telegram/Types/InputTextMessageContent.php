<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a text message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputtextmessagecontent
 */
class InputTextMessageContent
{
    /**
     * Text of the message to be sent, 1-4096 characters
     * @var string
     */
    public string $message_text;
    
    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     * @var string
     */
    public string $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[]
     */
    public array $entities;
    
    /**
     * Optional. Disables link previews for links in the sent message
     * @var string
     */
    public string $disable_web_page_preview;
}
