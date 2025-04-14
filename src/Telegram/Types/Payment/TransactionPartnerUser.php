<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes a transaction with a user.
 * @see https://core.telegram.org/bots/api#transactionpartneruser
 */
class TransactionPartnerUser extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “user”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::USER;

    /**
     * Type of the transaction, currently one of
     * - “invoice_payment” for payments via invoices,
     * - “paid_media_payment” for payments for paid media,
     * - “gift_purchase” for gifts sent by the bot,
     * - “premium_purchase” for Telegram Premium subscriptions gifted by the bot,
     * - “business_account_transfer” for direct transfers from managed business accounts
     */
    public string $transaction_type;

    /**
     * Information about the user
     */
    public User $user;

    /**
     * Optional. Information about the affiliate that received a commission via this transaction
     */
    public ?AffiliateInfo $affiliate = null;

    /**
     * Optional. Bot-specified invoice payload
     */
    public ?string $invoice_payload = null;

    /**
     * Optional. The duration of the paid subscription
     */
    public ?int $subscription_period = null;

    /**
     * Optional. Information about the paid media bought by the user
     * @var PaidMedia[]|null
     */
    #[ArrayType(PaidMedia::class)]
    public ?array $paid_media = null;

    /**
     * Optional. Bot-specified paid media payload
     */
    public ?string $paid_media_payload = null;

    /**
     * Optional. The gift sent to the user by the bot
     */
    public ?string $gift = null;

    /**
     * Optional.
     * Number of months the gifted Telegram Premium subscription will be active for;
     * for “premium_purchase” transactions only
     */
    public ?int $premium_subscription_duration = null;
}
