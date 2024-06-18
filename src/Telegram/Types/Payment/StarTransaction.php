<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes a Telegram Star transaction.
 * @see https://core.telegram.org/bots/api#startransaction
 */
class StarTransaction extends BaseType implements JsonSerializable
{
    /**
     * Unique identifier of the transaction.
     * Coincides with the identifer of the original transaction for refund transactions.
     * Coincides with SuccessfulPayment.telegram_payment_charge_id for successful incoming payments from users.
     */
    public string $id;

    /**
     * Number of Telegram Stars transferred by the transaction
     */
    public int $amount;

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

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'source' => $this->source,
            'receiver' => $this->receiver,
        ]);
    }
}
