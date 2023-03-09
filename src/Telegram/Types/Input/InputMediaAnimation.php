<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents an animation file (GIF or H.264/MPEG-4 AVC video without sound) to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaanimation
 */
class InputMediaAnimation extends InputMedia
{
    /**
     * Optional. Thumbnail of the file sent;
     * can be ignored if thumbnail generation for the file is supported server-side.
     * The thumbnail should be in JPEG format and less than 200 kB in size.
     * A thumbnail‘s width and height should not exceed 320.
     * Ignored if the file is not uploaded using multipart/form-data.
     * Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass
     * “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>.
     * @see https://core.telegram.org/bots/api#sending-files More info on Sending Files
     */
    public mixed $thumbnail;

    /**
     * Optional. Send Markdown or HTML, if you want Telegram apps to show
     * bold, italic, fixed-width text or inline URLs in the media caption.
     * @see https://core.telegram.org/bots/api#markdown-style Markdown
     * @see https://core.telegram.org/bots/api#html-style HTML
     * @see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs
     */
    public ?string $parse_mode = null;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var \SergiX44\Nutgram\Telegram\Types\Message\MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. Video width
     */
    public ?int $width = null;

    /**
     * Optional. Video height
     */
    public ?int $height = null;

    /**
     * Optional. Video duration
     */
    public ?int $duration = null;

    /**
     * Optional. Pass True if the animation needs to be covered with a spoiler animation
     */
    public ?bool $has_spoiler = null;
}
