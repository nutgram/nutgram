<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\RevenueWithdrawalStateResolver;

/**
 * This object describes the state of a revenue withdrawal operation.
 * Currently, it can be one of
 * - {@see RevenueWithdrawalStatePending}
 * - {@see RevenueWithdrawalStateSucceeded}
 * - {@see RevenueWithdrawalStateFailed}
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstate
 */
#[RevenueWithdrawalStateResolver]
interface RevenueWithdrawalState
{
}
