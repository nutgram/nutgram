<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

/**
 * Describes a withdrawal transaction to the Telegram Ads platform.
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramads
 */
class TransactionPartnerTelegramAds extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “telegram_ads”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::TELEGRAM_ADS;
}
