<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

/**
 * Describes a withdrawal transaction with Fragment.
 * @see https://core.telegram.org/bots/api#transactionpartnerfragment
 */
class TransactionPartnerFragment extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “fragment”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::FRAGMENT;

    /**
     * Optional. State of the transaction if the transaction is outgoing
     */
    public ?RevenueWithdrawalState $withdrawal_state = null;
}
