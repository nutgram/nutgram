<?php

namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

/**
 * @mixin CollectHandlers
 */
trait UpdateHandlers
{
    /**
     * @param $callable
     * @return Handler
     */
    public function onMessage($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param  string  $type
     * @param $callable
     * @return Handler
     */
    public function onMessageType(MessageType $type, $callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][$type->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        return $this->{$this->target}[UpdateType::EDITED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        return $this->{$this->target}[UpdateType::CHANNEL_POST->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        return $this->{$this->target}[UpdateType::EDITED_CHANNEL_POST->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateType::INLINE_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        return $this->{$this->target}[UpdateType::CHOSEN_INLINE_RESULT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateType::CALLBACK_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateType::CALLBACK_QUERY->value][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateType::SHIPPING_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateType::PRE_CHECKOUT_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQueryPayload(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateType::PRE_CHECKOUT_QUERY->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onUpdatePoll($callable): Handler
    {
        return $this->{$this->target}[UpdateType::POLL->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        return $this->{$this->target}[UpdateType::POLL_ANSWER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMyChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MY_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateType::CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatJoinRequest($callable): Handler
    {
        return $this->{$this->target}[UpdateType::CHAT_JOIN_REQUEST->value][] = new Handler($callable);
    }
}
