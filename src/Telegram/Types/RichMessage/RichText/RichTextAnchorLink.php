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
 * A link to an anchor.
 * @see https://core.telegram.org/bots/api#richtextanchorlink
 */
class RichTextAnchorLink extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “anchor_link”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::ANCHOR_LINK;

    /**
     * The link text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * The name of the anchor.
     * If the name is empty, then the link brings back to the top of the message.
     */
    public string $anchor_name;
}
