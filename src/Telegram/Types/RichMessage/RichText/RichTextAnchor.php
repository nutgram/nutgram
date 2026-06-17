<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * An anchor.
 * @see https://core.telegram.org/bots/api#richtextanchor
 */
class RichTextAnchor extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “anchor”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::ANCHOR;

    /**
     * The name of the anchor
     */
    public string $name;
}
