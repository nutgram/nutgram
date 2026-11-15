<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * An address in the TON blockchain.
 * @see https://core.telegram.org/bots/api#richtexttonaddress
 */
class RichTextTonAddress extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “ton_address”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::TON_ADDRESS;

    /**
     * Text of the address
     * @var string|RichText|array<mixed>
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * The address
     */
    public string $address;
}
