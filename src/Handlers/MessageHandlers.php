<?php

namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
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
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::TEXT][$command] = new Command($callable, $command);
    }

    /**
     * @param  string|Command  $command
     * @return Command
     */
    public function registerCommand(string|Command $command): Command
    {
        if (is_string($command)) {
            if (!is_subclass_of($command, Command::class)) {
                throw new InvalidArgumentException(sprintf('You must provide subclass of the %s class or an instance.', Command::class));
            }
            $command = new $command();
        }

        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::TEXT][$command->getPattern()] = $command;
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::TEXT][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAnimation($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::ANIMATION][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAudio($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::AUDIO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDocument($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::DOCUMENT][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSticker($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::STICKER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideo($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoNote($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO_NOTE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVoice($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VOICE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onContact($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::CONTACT][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDice($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::DICE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGame($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::GAME][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessagePoll($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::POLL][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVenue($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VENUE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLocation($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::LOCATION][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatMembers($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_MEMBERS][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLeftChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::LEFT_CHAT_MEMBER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatTitle($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_TITLE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::NEW_CHAT_PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDeleteChatPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::DELETE_CHAT_PHOTO][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGroupChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::GROUP_CHAT_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSupergroupChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::SUPERGROUP_CHAT_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::CHANNEL_CHAT_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessageAutoDeleteTimerChanged($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::MESSAGE_AUTO_DELETE_TIMER_CHANGED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateToChatId($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::MIGRATE_TO_CHAT_ID][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateFromChatId($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::MIGRATE_FROM_CHAT_ID][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPinnedMessage($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::PINNED_MESSAGE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInvoice($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::INVOICE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPayment($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPaymentPayload(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onConnectedWebsite($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::CONNECTED_WEBSITE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPassportData($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::PASSPORT_DATA][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onProximityAlertTriggered($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::PROXIMITY_ALERT_TRIGGERED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicEdited($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_EDITED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicClosed($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CLOSED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicReopened($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_REOPENED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatScheduled($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO_CHAT_SCHEDULED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatStarted($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO_CHAT_STARTED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatEnded($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO_CHAT_ENDED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatParticipantsInvited($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::VIDEO_CHAT_PARTICIPANTS_INVITED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onWebAppData($callable): Handler
    {
        return $this->{$this->target}[UpdateTypes::MESSAGE][MessageTypes::WEB_APP_DATA][] = new Handler($callable);
    }
}
