<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\SubscriptionState;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about changes to a user payment subscription toward the current bot.
 * @see https://core.telegram.org/bots/api#botsubscriptionupdated
 */
class BotSubscriptionUpdated extends BaseType
{
    /**
     * User who subscribed for payments toward the bot
     */
    public User $user;

    /**
     * Bot-specified invoice payload
     */
    public string $invoice_payload;

    /**
     * The new state of the subscription.
     * Currently, it can be one of
     * - “canceled” if the user canceled the subscription,
     * - “active” if the user re-enabled a previously canceled subscription, or
     * - “failed” if payment for the subscription failed.
     */
    #[EnumOrScalar]
    public SubscriptionState|string $state;
}
