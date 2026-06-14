<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A text with a bank card number.
 * @see https://core.telegram.org/bots/api#richtextbankcardnumber
 */
class RichTextBankCardNumber extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “bank_card_number”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::BANK_CARD_NUMBER;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * The bank card number
     */
    public string $bank_card_number;
}
