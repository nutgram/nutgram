<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Contains parameters of a post that is being suggested by the bot.
 * @see https://core.telegram.org/bots/api#suggestedpostparameters
 */
class SuggestedPostParameters extends BaseType
{
    /**
     * Optional. Proposed price for the post. If the field is omitted, then the post is unpaid.
     */
    public ?SuggestedPostPrice $price = null;

    /**
     * Optional. Proposed send date of the post.
     * If specified, then the date must be between 300 second and 2678400 seconds (30 days) in the future.
     * If the field is omitted, then the post can be published at any time within 30 days at the sole discretion of the user who approves it.
     */
    public ?int $send_date = null;

    public function __construct(?SuggestedPostPrice $price = null, ?int $send_date = null)
    {
        $this->price = $price;
        $this->send_date = $send_date;
        parent::__construct();
    }

    public static function make(?SuggestedPostPrice $price = null, ?int $send_date = null): self
    {
        return new self($price, $send_date);
    }
}
