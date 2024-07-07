<?php

namespace SergiX44\Nutgram\Handlers\Listeners;

use InvalidArgumentException;
use SergiX44\Nutgram\Handlers\CollectHandlers;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

/**
 * @mixin CollectHandlers
 */
trait MessageListeners
{
    /**
     * @param  string  $command
     * @param $callable
     * @return Command
     */
    public function onCommand(string $command, $callable, UpdateType $target = UpdateType::MESSAGE): Command
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::TEXT->value][$command] = new Command(
            $callable,
            $command
        );
    }

    /**
     * @param  string|Command  $command
     * @return Command
     */
    public function registerCommand(string|Command $command, UpdateType $target = UpdateType::MESSAGE): Command
    {
        $this->checkFinalized();
        $target->validateMessageType();
        if (is_string($command)) {
            if (!is_subclass_of($command, Command::class)) {
                throw new InvalidArgumentException(sprintf('You must provide subclass of the %s class or an instance.', Command::class));
            }
            $command = new $command();
        }

        return $this->{$this->target}[$target->value][MessageType::TEXT->value][$command->getPattern()] = $command;
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::TEXT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAnimation($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::ANIMATION->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onAudio($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::AUDIO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDocument($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DOCUMENT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSticker($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::STICKER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideo($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoNote($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_NOTE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVoice($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VOICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onContact($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CONTACT->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDice($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGame($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GAME->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessagePoll($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::POLL->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVenue($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VENUE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLocation($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::LOCATION->value][] = new Handler($callable);
    }

    public function onStory($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::STORY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatMembers($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_MEMBERS->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onLeftChatMember($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::LEFT_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatTitle($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_TITLE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onNewChatPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onDeleteChatPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DELETE_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGroupChatCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSupergroupChatCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUPERGROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelChatCreated($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CHANNEL_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessageAutoDeleteTimerChanged($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::MESSAGE_AUTO_DELETE_TIMER_CHANGED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateToChatId($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_TO_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMigrateFromChatId($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_FROM_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPinnedMessage($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::PINNED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInvoice($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::INVOICE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPayment($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPaymentPayload(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onRefundedPayment($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::REFUNDED_PAYMENT->value][] = new Handler($callable);
    }

    /**
     * @param string $pattern
     * @param $callable
     * @return Handler
     */
    public function onRefundedPaymentPayload(string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::REFUNDED_PAYMENT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onUsersShared($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::USERS_SHARED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatShared($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHAT_SHARED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onConnectedWebsite($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CONNECTED_WEBSITE->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPassportData($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PASSPORT_DATA->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onProximityAlertTriggered($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PROXIMITY_ALERT_TRIGGERED->value][] = new Handler($callable);
    }

    public function onBoostAdded($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::BOOST_ADDED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicEdited($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_EDITED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicClosed($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CLOSED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicReopened($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_REOPENED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGiveawayCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGiveaway($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGiveawayWinners($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_WINNERS->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onGiveawayCompleted($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_COMPLETED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatScheduled($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_SCHEDULED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatStarted($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_STARTED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatEnded($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_ENDED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onVideoChatParticipantsInvited($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_PARTICIPANTS_INVITED->value][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onWebAppData($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::WEB_APP_DATA->value][] = new Handler($callable);
    }
}
