<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents an audio file to be treated as music to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaaudio
 */
class InputMediaAudio extends InputMedia implements JsonSerializable
{
    /** Type of the result, must be audio */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::AUDIO;

    /**
     * Optional.
     * Thumbnail of the file sent;
     * can be ignored if thumbnail generation for the file is supported server-side.
     * The thumbnail should be in JPEG format and less than 200 kB in size.
     * A thumbnail's width and height should not exceed 320.
     * Ignored if the file is not uploaded using multipart/form-data.
     * Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string|null $thumbnail = null;

    /**
     * Optional.
     * Caption of the audio to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the audio caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    #[EnumOrScalar]
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional.
     * Duration of the audio in seconds
     */
    public ?int $duration = null;

    /**
     * Optional.
     * Performer of the audio
     */
    public ?string $performer = null;

    /**
     * Optional.
     * Title of the audio
     */
    public ?string $title = null;

    public function __construct(
        InputFile|string $media,
        InputFile|string|null $thumbnail,
        ?string $caption,
        ParseMode|string|null $parse_mode,
        ?array $caption_entities,
        ?int $duration,
        ?string $performer,
        ?string $title
    ) {
        parent::__construct();
        $this->media = $media;
        $this->thumbnail = $thumbnail;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->duration = $duration;
        $this->performer = $performer;
        $this->title = $title;
    }

    public static function make(
        InputFile|string $media,
        InputFile|string|null $thumbnail = null,
        ?string $caption = null,
        ?ParseMode $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
        ?string $performer = null,
        ?string $title = null
    ): self {
        return new self(
            media: $media,
            thumbnail: $thumbnail,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            duration: $duration,
            performer: $performer,
            title: $title
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
            'thumb' => $this->thumbnail,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode?->value,
            'caption_entities' => $this->caption_entities,
            'duration' => $this->duration,
            'performer' => $this->performer,
            'title' => $this->title
        ]);
    }
}
