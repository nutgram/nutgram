<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\SuggestedPostInfoState;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Contains information about a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostinfo
 */
class SuggestedPostInfo extends BaseType
{
    /**
     * State of the suggested post. Currently, it can be one of “pending”, “approved”, “declined”.
     */
    #[EnumOrScalar]
    public SuggestedPostInfoState|string $state;

    /**
     * Optional. Proposed price of the post. If the field is omitted, then the post is unpaid.
     */
    public ?SuggestedPostPrice $price = null;

    /**
     * Optional. Proposed send date of the post.
     * If the field is omitted, then the post can be published at any time within 30 days at the sole discretion of the user or administrator who approves it.
     */
    public ?int $send_date = null;
}
