<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a photo to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaphoto
 */
class InputMediaPhoto
{
    /**
     * Type of the result, must be photo
     * @var string $type
     */
    public $type;

    /**
     * File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>”
     * to upload a new one using multipart/form-data under <file_attach_name> name.
     * @see https://core.telegram.org/bots/api#sending-files More info on Sending Files
     * @var string $media
     */
    public $media;

    /**
     * Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing
     * @var string $caption
     */
    public $caption;

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
