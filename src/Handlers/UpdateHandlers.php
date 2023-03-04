<?php

namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Enums\MessageTypes;
use SergiX44\Nutgram\Telegram\Enums\UpdateTypes;

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
        return $this->{$this->target}[UpdateTypes::MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param  string  $type
     * @param $callable
     * @return Handler
     */
    public function onMessageType(string $type, $callable): Handler
    {
        if (!in_array($type, MessageTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid message type.');
        }
        return $this->{$this->target}[UpdateTypes::MESSAGE->value][$type][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::EDITED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CHANNEL_POST->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::EDITED_CHANNEL_POST->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::INLINE_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CHOSEN_INLINE_RESULT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CALLBACK_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CALLBACK_QUERY->value][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::SHIPPING_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::PRE_CHECKOUT_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQueryPayload(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::PRE_CHECKOUT_QUERY->value][$pattern] = new Handler($callable,
            $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onUpdatePoll($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::POLL->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::POLL_ANSWER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMyChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MY_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatJoinRequest($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::CHAT_JOIN_REQUEST->value][] = new Handler($callable);
    }
}
