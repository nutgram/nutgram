<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a Telegram Star transaction.
 * @see https://core.telegram.org/bots/api#startransaction
 */
class StarTransaction extends BaseType
{
    /**
     * Unique identifier of the transaction.
     * Coincides with the identifier of the original transaction for refund transactions.
     * Coincides with SuccessfulPayment.telegram_payment_charge_id for successful incoming payments from users.
     */
    public string $id;

    /**
     * Number of Telegram Stars transferred by the transaction
     */
    public int $amount;

    /**
     * Optional.
     * The number of 1/1000000000 shares of Telegram Stars transferred by the transaction;
     * from 0 to 999999999
     */
    public ?int $nanostar_amount = null;

    /**
     * Date the transaction was created in Unix time
     */
    public int $date;

    /**
     * Optional.
     * Source of an incoming transaction (e.g., a user purchasing goods or services, Fragment refunding a failed withdrawal).
     * Only for incoming transactions
     */
    public ?TransactionPartner $source = null;

    /**
     * Optional.
     * Receiver of an outgoing transaction (e.g., a user for a purchase refund, Fragment for a withdrawal).
     * Only for outgoing transactions
     */
    public ?TransactionPartner $receiver = null;
}
