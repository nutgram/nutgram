<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes paid media. Currently, it can be one of:
 * - {@see PaidMediaPreview}
 * - {@see PaidMediaPhoto}
 * - {@see PaidMediaVideo}
 * @see https://core.telegram.org/bots/api#paidmedia
 */
#[PaidMediaResolver]
abstract class PaidMedia extends BaseType
{
    /**
     * Type of the transaction partner, can be “preview”, “photo”, or “video”.
     */
    #[EnumOrScalar]
    public PaidMediaType|string $type;
}
