<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\TransactionPartnerResolver;

/**
 * This object describes the source of a transaction, or its recipient for outgoing transactions.
 * Currently, it can be one of:
 * - {@see TransactionPartnerFragment}
 * - {@see TransactionPartnerUser}
 * - {@see TransactionPartnerAffiliateProgram}
 * - {@see TransactionPartnerTelegramAds}
 * - {@see TransactionPartnerTelegramApi}
 * - {@see TransactionPartnerOther}
 * - {@see TransactionPartnerChat}
 * @see https://core.telegram.org/bots/api#transactionpartner
 */
#[TransactionPartnerResolver]
interface TransactionPartner
{
}
