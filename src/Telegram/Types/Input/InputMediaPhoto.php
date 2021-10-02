<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a photo to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaphoto
 */
class InputMediaPhoto extends InputMedia
{
    /**
     * Optional. Send Markdown or HTML, if you want Telegram apps to show
     * bold, italic, fixed-width text or inline URLs in the media caption.
     * @see https://core.telegram.org/bots/api#markdown-style Markdown
     * @see https://core.telegram.org/bots/api#html-style HTML
     * @see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs
     * @var string $parse_mode
     */
    public $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    public $caption_entities;
}
