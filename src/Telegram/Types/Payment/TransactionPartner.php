<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the source of a transaction, or its recipient for outgoing transactions.
 * Currently, it can be one of:
 * - {@see TransactionPartnerFragment}
 * - {@see TransactionPartnerUser}
 * - {@see TransactionPartnerAffiliateProgram}
 * - {@see TransactionPartnerTelegramAds}
 * - {@see TransactionPartnerTelegramApi}
 * - {@see TransactionPartnerOther}
 * @see https://core.telegram.org/bots/api#transactionpartner
 */
#[TransactionPartnerResolver]
abstract class TransactionPartner extends BaseType
{
    /**
     * Type of the transaction partner.
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type;
}
