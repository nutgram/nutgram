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
}
