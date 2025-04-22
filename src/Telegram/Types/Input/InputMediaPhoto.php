<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a photo to be sent.
 * @see https://core.telegram.org/bots/api#inputmediaphoto
 */
#[OverrideConstructor('bindToInstance')]
class InputMediaPhoto extends InputMedia
{
    /** Type of the result, must be photo */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::PHOTO;

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
     * Optional. True, if the caption must be shown above the message media
     */
    public ?bool $show_caption_above_media = null;

    /**
     * Optional.
     * Pass True if the photo needs to be covered with a spoiler animation
     */
    public ?bool $has_spoiler = null;

    public function __construct(
        InputFile|string $media,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $show_caption_above_media = null,
    ) {
        parent::__construct();
        $this->media = $media;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->has_spoiler = $has_spoiler;
        $this->show_caption_above_media = $show_caption_above_media;
    }
}
