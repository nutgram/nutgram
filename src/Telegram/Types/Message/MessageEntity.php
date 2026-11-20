<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageEntityType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents one special entity in a text message.
 * For example, hashtags, usernames, URLs, etc.
 * @see https://core.telegram.org/bots/api#messageentity
 */
#[OverrideConstructor('bindToInstance')]
class MessageEntity extends BaseType
{
    /**
     * Type of the entity.
     * Currently, can be
     * “mention” (&#64;username),
     * “hashtag” (#hashtag or #hashtag&#64;chatusername),
     * “cashtag” ($USD or $USD&#64;chatusername),
     * “bot_command” (/start&#64;jobs_bot),
     * “url” (https://telegram.org),
     * “email” (do-not-reply&#64;telegram.org),
     * “phone_number” (+1-212-555-0123),
     * “bank_card_number” (bank card number),
     * “ton_address” (address in the TON blockchain),
     * “bold” (bold text),
     * “italic” (italic text),
     * “underline” (underlined text),
     * “strikethrough” (strikethrough text),
     * “spoiler” (spoiler message),
     * “blockquote” (block quotation),
     * “expandable_blockquote” (collapsed-by-default block quotation),
     * “code” (monowidth string),
     * “pre” (monowidth block),
     * “text_link” (for clickable text URLs),
     * “text_mention” (for users {@see https://telegram.org/blog/edit#new-mentions without usernames}),
     * “custom_emoji” (for inline custom emoji stickers),
     * or “date_time” (for formatted date and time)
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

    /**
     * Optional.
     * For “date_time” only, the Unix time associated with the entity
     */
    public ?int $unix_time = null;

    /**
     * Optional.
     * For “date_time” only, the string that defines the formatting of the date and time.
     * See {@see https://core.telegram.org/bots/api#date-time-entity-formatting date-time entity formatting} for more details.
     */
    public ?string $date_time_format = null;

    public function __construct(
        MessageEntityType|string $type,
        int $offset,
        int $length,
        ?string $url = null,
        ?User $user = null,
        ?string $language = null,
        ?string $custom_emoji_id = null,
        ?int $unix_time = null,
        ?string $date_time_format = null,
    ) {
        parent::__construct();
        $this->type = $type;
        $this->offset = $offset;
        $this->length = $length;
        $this->url = $url;
        $this->user = $user;
        $this->language = $language;
        $this->custom_emoji_id = $custom_emoji_id;
        $this->unix_time = $unix_time;
        $this->date_time_format = $date_time_format;
    }
}
