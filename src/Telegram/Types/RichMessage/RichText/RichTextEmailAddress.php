<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A text with an email address.
 * @see https://core.telegram.org/bots/api#richtextemailaddress
 */
class RichTextEmailAddress extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “email_address”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::EMAIL_ADDRESS;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    public string|array|RichText $text;

    /**
     * The email address
     */
    public string $email_address;
}
