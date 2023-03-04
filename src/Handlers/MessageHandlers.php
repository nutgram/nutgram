<?php

namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Enums\MessageType;
use SergiX44\Nutgram\Telegram\Enums\UpdateType;

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
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::TEXT->value][$command] = new Command(
            $callable,
            $command
        );
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

        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::TEXT->value][$command->getPattern()] = $command;
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::TEXT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAnimation($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::ANIMATION->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAudio($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::AUDIO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDocument($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::DOCUMENT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSticker($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::STICKER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideo($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoNote($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO_NOTE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVoice($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VOICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onContact($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CONTACT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDice($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::DICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGame($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GAME->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessagePoll($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::POLL->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVenue($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VENUE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLocation($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::LOCATION->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatMembers($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::NEW_CHAT_MEMBERS->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLeftChatMember($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::LEFT_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatTitle($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::NEW_CHAT_TITLE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::NEW_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDeleteChatPhoto($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::DELETE_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGroupChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSupergroupChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUPERGROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelChatCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHANNEL_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessageAutoDeleteTimerChanged($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MESSAGE_AUTO_DELETE_TIMER_CHANGED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateToChatId($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_TO_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateFromChatId($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_FROM_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPinnedMessage($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PINNED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInvoice($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::INVOICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPayment($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPaymentPayload(string $pattern, $callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][$pattern] = new Handler(
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
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CONNECTED_WEBSITE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPassportData($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PASSPORT_DATA->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onProximityAlertTriggered($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PROXIMITY_ALERT_TRIGGERED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicCreated($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicEdited($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_EDITED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicClosed($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CLOSED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicReopened($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_REOPENED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatScheduled($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO_CHAT_SCHEDULED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatStarted($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO_CHAT_STARTED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatEnded($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO_CHAT_ENDED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatParticipantsInvited($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::VIDEO_CHAT_PARTICIPANTS_INVITED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onWebAppData($callable): Handler
    {
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::WEB_APP_DATA->value][] = new Handler($callable);
    }
}
