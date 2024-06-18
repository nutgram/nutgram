<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

/**
 * The withdrawal succeeded.
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatesucceeded
 */
class RevenueWithdrawalStateSucceeded extends RevenueWithdrawalState
{
    /**
     * Type of the state, always “succeeded”
     */
    #[EnumOrScalar]
    public RevenueWithdrawalStateType|string $type = RevenueWithdrawalStateType::SUCCEEDED;

    /**
     * Date the withdrawal was completed in Unix time
     */
    public int $date;

    /**
     * An HTTPS URL that can be used to see transaction details
     */
    public string $url;
}
