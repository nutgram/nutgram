<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum UniqueGiftInfoOrigin: string
{
    /**
     * For gifts upgraded from regular gifts.
     */
    case UPGRADE = 'upgrade';

    /**
     * For gifts transferred from other users or channels.
     */
    case TRANSFER = 'transfer';

    /**
     * For gifts bought from other users.
     */
    case RESALE = 'resale';

    /**
     * For upgrades purchased after the gift was sent.
     */
    case GIFTED_UPGRADE = 'gifted_upgrade';

    /**
     * For gifts bought or sold through gift purchase offers.
     */
    case OFFER = 'offer';
}
