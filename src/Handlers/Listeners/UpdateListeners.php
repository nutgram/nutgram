<?php

namespace SergiX44\Nutgram\Handlers\Listeners;

use SergiX44\Nutgram\Handlers\CollectHandlers;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

/**
 * @mixin CollectHandlers
 */
trait UpdateListeners
{
    /**
     * @param $callable
     * @return Handler
     */
    public function onMessage($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param  MessageType  $type
     * @param $callable
     * @return Handler
     */
    public function onMessageType(MessageType $type, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][$type->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::EDITED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHANNEL_POST->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::EDITED_CHANNEL_POST->value][] = new Handler($callable);
    }

    public function onBusinessConnection($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::BUSINESS_CONNECTION->value][] = new Handler($callable);
    }

    public function onBusinessMessage($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::BUSINESS_MESSAGE->value][] = new Handler($callable);
    }

    public function onEditedBusinessMessage($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::EDITED_BUSINESS_MESSAGE->value][] = new Handler($callable);
    }

    public function onDeletedBusinessMessages($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::DELETED_BUSINESS_MESSAGES->value][] = new Handler($callable);
    }

    public function onMessageReaction($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE_REACTION->value][] = new Handler($callable);
    }

    public function onMessageReactionCount($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE_REACTION_COUNT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::INLINE_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param string $pattern
     * @param $callable
     * @return Handler
     */
    public function onInlineQueryText(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::INLINE_QUERY->value][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHOSEN_INLINE_RESULT->value][] = new Handler($callable);
    }

    /**
     * @param string $pattern
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResultQuery(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHOSEN_INLINE_RESULT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CALLBACK_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CALLBACK_QUERY->value][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::SHIPPING_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::PRE_CHECKOUT_QUERY->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQueryPayload(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
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
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::POLL->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::POLL_ANSWER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMyChatMember($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MY_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatMember($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatJoinRequest($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHAT_JOIN_REQUEST->value][] = new Handler($callable);
    }

    public function onChatBoost($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::CHAT_BOOST->value][] = new Handler($callable);
    }

    public function onRemovedChatBoost($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::REMOVED_CHAT_BOOST->value][] = new Handler($callable);
    }
}
