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
 * Formatted date and time.
 * @see https://core.telegram.org/bots/api#richtextdatetime
 */
class RichTextDateTime extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “date_time”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::DATETIME;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * The Unix time associated with the entity
     */
    public int $unix_time;

    /**
     * The string that defines the formatting of the date and time.
     * See {@see https://core.telegram.org/bots/api#date-time-entity-formatting date-time entity formatting}
     * for more details.
     */
    public string $date_time_format;
}
