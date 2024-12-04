<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\User\User;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes the affiliate program that issued the affiliate commission received via this transaction.
 * @see https://core.telegram.org/bots/api#transactionpartneraffiliateprogram
 */
class TransactionPartnerAffiliateProgram extends TransactionPartner implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'sponsor_user' => $this->sponsor_user,
            'commission_per_mille' => $this->commission_per_mille,
        ]);
    }
}
