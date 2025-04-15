<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes the affiliate program that issued the affiliate commission received via this transaction.
 * @see https://core.telegram.org/bots/api#transactionpartneraffiliateprogram
 */
class TransactionPartnerAffiliateProgram extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “affiliate_program”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::AFFILIATE_PROGRAM;

    /**
     * Optional. Information about the bot that sponsored the affiliate program
     */
    public ?User $sponsor_user = null;

    /**
     * The number of Telegram Stars received by the bot for each 1000 Telegram Stars received by the affiliate program sponsor from referred users
     */
    public int $commission_per_mille;
}
