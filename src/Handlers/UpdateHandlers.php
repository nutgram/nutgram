<?php

namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

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
        return $this->handlers[UpdateTypes::MESSAGE][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
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
        return $this->handlers[UpdateTypes::MESSAGE][$type][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        return $this->handlers[UpdateTypes::EDITED_MESSAGE][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHANNEL_POST][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        return $this->handlers[UpdateTypes::EDITED_CHANNEL_POST][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::INLINE_QUERY][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHOSEN_INLINE_RESULT][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::CALLBACK_QUERY][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::CALLBACK_QUERY][$pattern] = new Handler($callable, $pattern,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::SHIPPING_QUERY][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::PRE_CHECKOUT_QUERY][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQueryPayload(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::PRE_CHECKOUT_QUERY][$pattern] = new Handler($callable, $pattern,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     * @deprecated This handler is deprecated and will be removed in the next major version.
     * @see Nutgram::onUpdatePoll()
     */
    public function onPoll($callable): Handler
    {
        return $this->handlers[UpdateTypes::POLL][] = new Handler($callable, groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onUpdatePoll($callable): Handler
    {
        return $this->handlers[UpdateTypes::POLL][] = new Handler($callable, groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        return $this->handlers[UpdateTypes::POLL_ANSWER][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMyChatMember($callable): Handler
    {
        return $this->handlers[UpdateTypes::MY_CHAT_MEMBER][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatMember($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHAT_MEMBER][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatJoinRequest($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHAT_JOIN_REQUEST][] = new Handler($callable,
            groupMiddlewares: $this->groupMiddlewares);
    }
}
