<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\RichTextUnionResolver;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * A mention of a Telegram user by their identifier.
 * @see https://core.telegram.org/bots/api#richtexttextmention
 */
class RichTextTextMention extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “text_mention”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::TEXT_MENTION;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * The mentioned user
     */
    public User $user;
}
