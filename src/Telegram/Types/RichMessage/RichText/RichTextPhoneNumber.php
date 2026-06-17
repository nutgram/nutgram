<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\RichTextUnionResolver;

/**
 * A text with a phone number.
 * @see https://core.telegram.org/bots/api#richtextphonenumber
 */
class RichTextPhoneNumber extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “phone_number”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::PHONE_NUMBER;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * The phone number
     */
    public string $phone_number;
}
