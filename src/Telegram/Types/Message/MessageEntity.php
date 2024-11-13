<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageEntityType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents one special entity in a text message.
 * For example, hashtags, usernames, URLs, etc.
 * @see https://core.telegram.org/bots/api#messageentity
 */
#[SkipConstructor]
class MessageEntity extends BaseType implements JsonSerializable
{
    /**
     * Type of the entity.
     * Currently, can be “mention” (&#64;username), “hashtag” (#hashtag), “cashtag” ($USD), “bot_command” (/start&#64;jobs_bot), “url” (https://telegram.org), “email” (do-not-reply&#64;telegram.org), “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text), “strikethrough” (strikethrough text), “spoiler” (spoiler message), “code” (monowidth string), “pre” (monowidth block), “text_link” (for clickable text URLs), “text_mention” (for users {@see https://telegram.org/blog/edit#new-mentions without usernames}), “custom_emoji” (for inline custom emoji stickers)
     */
    #[EnumOrScalar]
    public MessageEntityType|string $type;

    /** Offset in {@see https://core.telegram.org/api/entities#entity-length UTF-16 code units} to the start of the entity */
    public int $offset;

    /** Length of the entity in {@see https://core.telegram.org/api/entities#entity-length UTF-16 code units} */
    public int $length;

    /**
     * Optional.
     * For “text_link” only, URL that will be opened after user taps on the text
     */
    public ?string $url = null;

    /**
     * Optional.
     * For “text_mention” only, the mentioned user
     */
    public ?User $user = null;

    /**
     * Optional.
     * For “pre” only, the programming language of the entity text
     */
    public ?string $language = null;

    /**
     * Optional.
     * For “custom_emoji” only, unique identifier of the custom emoji.
     * Use {@see https://core.telegram.org/bots/api#getcustomemojistickers getCustomEmojiStickers} to get full information about the sticker
     */
    public ?string $custom_emoji_id = null;

    public function __construct(
        MessageEntityType|string $type,
        int $offset,
        int $length,
        ?string $url = null,
        ?User $user = null,
        ?string $language = null,
        ?string $custom_emoji_id = null,
    ) {
        parent::__construct();
        $this->type = $type;
        $this->offset = $offset;
        $this->length = $length;
        $this->url = $url;
        $this->user = $user;
        $this->language = $language;
        $this->custom_emoji_id = $custom_emoji_id;
    }

    public static function make(
        MessageEntityType|string $type,
        int $offset,
        int $length,
        ?string $url = null,
        ?User $user = null,
        ?string $language = null,
        ?string $custom_emoji_id = null,
    ): self {
        return new self(
            type: $type,
            offset: $offset,
            length: $length,
            url: $url,
            user: $user,
            language: $language,
            custom_emoji_id: $custom_emoji_id
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'offset' => $this->offset,
            'length' => $this->length,
            'url' => $this->url,
            'user' => $this->user,
            'language' => $this->language,
            'custom_emoji_id' => $this->custom_emoji_id,
        ]);
    }
}
