<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a service message about a transfer with a TON wallet.
 * @see https://core.telegram.org/bots/api#tonwallettransfer
 */
class TonWalletTransfer extends BaseType
{
    /**
     * Unique identifier of the transaction; may be empty if the transfer hasn't been sent yet
     */
    public string $transaction_id;

    /**
     * Address of the transfer peer in the TON blockchain
     */
    public string $peer_address;

    /**
     * The amount of transferred cryptocurrency, in the smallest units of the cryptocurrency, as a decimal number;
     * negative for outgoing transfers
     */
    public string $amount;

    /**
     * Optional. Comment added to the transfer; omitted if the comment is encrypted
     */
    public ?string $comment = null;
}
