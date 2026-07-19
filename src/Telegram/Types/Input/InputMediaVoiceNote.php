<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadables;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a video to be sent.
 * @see https://core.telegram.org/bots/api#inputmediavideo
 */
#[OverrideConstructor('bindToInstance')]
class InputMediaVoiceNote extends BaseType implements Uploadables
{
    /** Type of the result, must be video */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::VOICE_NOTE;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    #[BaseUnion]
    public InputFile|string $media;

    /**
     * Optional.
     * Caption of the voice message to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the voice message caption.
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
     * Duration of the voice message in seconds
     */
    public ?int $duration = null;

    public function __construct(
        InputFile|string $media,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
    ) {
        parent::__construct();
        $this->media = $media;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->duration = $duration;
    }

    public function uploadables(): array
    {
        return ['media'];
    }
}
