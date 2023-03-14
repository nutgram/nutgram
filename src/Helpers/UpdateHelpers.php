<?php

namespace SergiX44\Nutgram\Helpers;

use SergiX44\Nutgram\Telegram\Types\Common\Update;

/**
 * @mixin Update
 */
trait UpdateHelpers
{
    public function isMessage(): bool
    {
        return $this->message !== null;
    }

    public function isEditedMessage(): bool
    {
        return $this->edited_message !== null;
    }

    public function isChannelPost(): bool
    {
        return $this->channel_post !== null;
    }

    public function isEditedChannelPost(): bool
    {
        return $this->edited_channel_post !== null;
    }

    public function isInlineQuery(): bool
    {
        return $this->inline_query !== null;
    }

    public function isChosenInlineResult(): bool
    {
        return $this->chosen_inline_result !== null;
    }

    public function isCallbackQuery(): bool
    {
        return $this->callback_query !== null;
    }

    public function isShippingQuery(): bool
    {
        return $this->shipping_query !== null;
    }

    public function isPreCheckoutQuery(): bool
    {
        return $this->pre_checkout_query !== null;
    }

    public function isPoll(): bool
    {
        return $this->poll !== null;
    }

    public function isPollAnswer(): bool
    {
        return $this->poll_answer !== null;
    }

    public function isMyChatMember(): bool
    {
        return $this->my_chat_member !== null;
    }

    public function isChatMember(): bool
    {
        return $this->chat_member !== null;
    }

    public function isChatJoinRequest(): bool
    {
        return $this->chat_join_request !== null;
    }
}
