<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\PaidMediaResolver;

/**
 * This object describes paid media. Currently, it can be one of:
 * - {@see PaidMediaLivePhoto}
 * - {@see PaidMediaPhoto}
 * - {@see PaidMediaPreview}
 * - {@see PaidMediaVideo}
 * @see https://core.telegram.org/bots/api#paidmedia
 */
#[PaidMediaResolver]
interface PaidMedia
{
}
