<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes a withdrawal transaction with Fragment.
 * @see https://core.telegram.org/bots/api#transactionpartnerfragment
 */
class TransactionPartnerFragment extends TransactionPartner implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'withdrawal_state' => $this->withdrawal_state,
        ]);
    }
}
