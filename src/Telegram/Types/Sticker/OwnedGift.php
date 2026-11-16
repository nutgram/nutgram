<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\OwnedGiftResolver;

/**
 * This object describes a gift received and owned by a user or a chat. Currently, it can be one of
 * - {@see OwnedGiftRegular}
 * - {@see OwnedGiftUnique}
 * @see https://core.telegram.org/bots/api#ownedgift
 */
#[OwnedGiftResolver]
interface OwnedGift
{
}
