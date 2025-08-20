<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum SuggestedPostRefundedReason: string
{
    case POST_DELETED = 'post_deleted';
    case PAYMENT_REFUNDED = 'payment_refunded';
}
