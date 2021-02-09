<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a general file to be sent.
 * @see https://core.telegram.org/bots/api#inputmediadocument
 */
class InputMediaDocument
{
    /**
     * Type of the result, must be document
     * @var string
     */
    public string $type;

    /**
     * File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>”
     * to upload a new one using multipart/form-data under <file_attach_name> name.
     * @see https://core.telegram.org/bots/api#sending-files More info on Sending Files
     * @var string
     */
    public string $media;

    /**
     * Optional. Thumbnail of the file sent;
     * can be ignored if thumbnail generation for the file is supported server-side.
     * The thumbnail should be in JPEG format and less than 200 kB in size.
     * A thumbnail‘s width and height should not exceed 320.
     * Ignored if the file is not uploaded using multipart/form-data.
     * Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass
     * “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>.
     * @see https://core.telegram.org/bots/api#sending-files More info on Sending Files
     * @var mixed
     */
    public $thumb;

    /**
     * Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing
     * @var string
     */
    public string $caption;

    /**
     * Optional. Send Markdown or HTML, if you want Telegram apps to show
     * bold, italic, fixed-width text or inline URLs in the media caption.
     * @see https://core.telegram.org/bots/api#markdown-style Markdown
     * @see https://core.telegram.org/bots/api#html-style HTML
     * @see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs
     * @var string
     */
    public string $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[]
     */
    public array $caption_entities;

    /**
     * Optional. Disables automatic server-side content type detection for files uploaded using multipart/form-data.
     * Always true, if the document is sent as part of an album.
     * @var bool
     */
    public bool $disable_content_type_detection;
}
