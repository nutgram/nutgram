<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a photo to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaphoto
 */
class InputMediaPhoto extends InputMedia implements JsonSerializable
{
    /** Type of the result, must be photo */
    public InputMediaType $type = InputMediaType::PHOTO;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $media;

    /**
     * Optional.
     * Caption of the photo to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the photo caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ?ParseMode $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional.
     * Pass True if the photo needs to be covered with a spoiler animation
     */
    public ?bool $has_spoiler = null;

    public function __construct(
        InputFile|string $media,
        ?string $caption,
        ?ParseMode $parse_mode,
        ?array $caption_entities,
        ?bool $has_spoiler
    ) {
        parent::__construct();
        $this->media = $media;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->has_spoiler = $has_spoiler;
    }

    public static function make(
        InputFile|string $media,
        ?string $caption = null,
        ?ParseMode $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null
    ): self {
        return new self(
            media: $media,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            has_spoiler: $has_spoiler
        );
    }


    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'media' => $this->media,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode?->value,
            'caption_entities' => $this->caption_entities,
            'has_spoiler' => $this->has_spoiler,
        ]);
    }
}
