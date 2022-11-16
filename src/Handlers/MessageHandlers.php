<?php

namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

/**
 * @mixin CollectHandlers
 */
trait MessageHandlers
{
    /**
     * @param  string  $command
     * @param $callable
     * @return Command
     */
    public function onCommand(string $command, $callable): Command
    {
        $command = "/$command";

        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::TEXT][$command] = new Command($callable, $command);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::TEXT][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAnimation($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::ANIMATION][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAudio($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::AUDIO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDocument($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::DOCUMENT][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPhoto($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSticker($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::STICKER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideo($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::VIDEO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoNote($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::VIDEO_NOTE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVoice($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::VOICE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onContact($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::CONTACT][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDice($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::DICE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGame($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::GAME][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVenue($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::VENUE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLocation($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::LOCATION][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatMembers($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_MEMBERS][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLeftChatMember($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::LEFT_CHAT_MEMBER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatTitle($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_TITLE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatPhoto($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDeleteChatPhoto($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::DELETE_CHAT_PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPayment($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPaymentPayload(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicCreated($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicClosed($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CLOSED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicReopened($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_REOPENED][] = new Handler($callable);
    }
}
