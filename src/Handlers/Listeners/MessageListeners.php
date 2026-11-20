<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Handlers\Listeners;

use BackedEnum;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Handlers\CollectHandlers;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\Type\Command\Command;
use SergiX44\Nutgram\Handlers\Type\Command\WithScopes;
use SergiX44\Nutgram\Handlers\Type\InternalCommand;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use function SergiX44\Nutgram\Support\get_value;

/**
 * @mixin CollectHandlers
 */
trait MessageListeners
{
    abstract public function getContainer(): Container;

    /**
     * @param callable|class-string|array $callable
     */
    public function onCommand(
        BackedEnum|string $command,
        $callable,
        UpdateType $target = UpdateType::MESSAGE
    ): InternalCommand {
        $this->checkFinalized();
        $target->validateMessageType();
        $command = get_value($command);

        $registeringCommand = new InternalCommand($callable, $command);

        if (is_array($callable)) {
            $callable = $callable[0];
        }

        if (is_string($callable)) {
            $callable = $this->getContainer()->make($callable);
        }

        if ($callable instanceof Command) {
            $registeringCommand->description($callable->description());
        }

        if ($callable instanceof WithScopes) {
            $registeringCommand->scope($callable->scopes());
        }

        return $this->{$this->target}[$target->value][MessageType::TEXT->value][$command] = $registeringCommand;
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onText(BackedEnum|string $pattern, $callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        $pattern = get_value($pattern);
        return $this->{$this->target}[$target->value][MessageType::TEXT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onRichMessage($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::RICH_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onAnimation($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::ANIMATION->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onAudio($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::AUDIO->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onDocument($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DOCUMENT->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onSticker($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::STICKER->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideo($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideoNote($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_NOTE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVoice($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VOICE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onContact($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CONTACT->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onDice($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DICE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGame($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GAME->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onMessagePoll($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::POLL->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVenue($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VENUE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onLocation($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::LOCATION->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onStory($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::STORY->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onNewChatMembers($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_MEMBERS->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onLeftChatMember($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::LEFT_CHAT_MEMBER->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChatOwnerLeft($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CHAT_OWNER_LEFT->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChatOwnerChanged($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CHAT_OWNER_CHANGED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onNewChatTitle($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_TITLE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onNewChatPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::NEW_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onDeleteChatPhoto($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::DELETE_CHAT_PHOTO->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGroupChatCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onSupergroupChatCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUPERGROUP_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChannelChatCreated($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::CHANNEL_CHAT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onMessageAutoDeleteTimerChanged($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::MESSAGE_AUTO_DELETE_TIMER_CHANGED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onMigrateToChatId($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_TO_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onMigrateFromChatId($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MIGRATE_FROM_CHAT_ID->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPinnedMessage($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::PINNED_MESSAGE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onInvoice($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::INVOICE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onSuccessfulPayment($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onSuccessfulPaymentPayload(BackedEnum|string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        $pattern = get_value($pattern);
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::SUCCESSFUL_PAYMENT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onRefundedPayment($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::REFUNDED_PAYMENT->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onRefundedPaymentPayload(BackedEnum|string $pattern, $callable): Handler
    {
        $this->checkFinalized();
        $pattern = get_value($pattern);
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::REFUNDED_PAYMENT->value][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onUsersShared($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::USERS_SHARED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChatShared($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHAT_SHARED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onConnectedWebsite($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CONNECTED_WEBSITE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPassportData($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PASSPORT_DATA->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onProximityAlertTriggered($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::PROXIMITY_ALERT_TRIGGERED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onBoostAdded($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::BOOST_ADDED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onDirectMessagePriceChanged($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::DIRECT_MESSAGE_PRICE_CHANGED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChecklist($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHECKLIST->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChecklistTasksDone($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHECKLIST_TASKS_DONE->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onChecklistTasksAdded($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::CHECKLIST_TASKS_ADDED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onForumTopicCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onForumTopicEdited($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_EDITED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onForumTopicClosed($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_CLOSED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onForumTopicReopened($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::FORUM_TOPIC_REOPENED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGiveawayCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGiveaway($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGiveawayWinners($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_WINNERS->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onGiveawayCompleted($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::GIVEAWAY_COMPLETED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideoChatScheduled($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_SCHEDULED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideoChatStarted($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_STARTED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideoChatEnded($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_ENDED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onVideoChatParticipantsInvited($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::VIDEO_CHAT_PARTICIPANTS_INVITED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onWebAppData($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::WEB_APP_DATA->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onManagedBotCreated($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::MANAGED_BOT_CREATED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPollOptionAdded($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::POLL_OPTION_ADDED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPollOptionDeleted($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[UpdateType::MESSAGE->value][MessageType::POLL_OPTION_DELETED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onCommunityChatAdded($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::COMMUNITY_CHAT_ADDED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onCommunityChatJoined($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::COMMUNITY_CHAT_JOINED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onCommunityChatRemoved($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::COMMUNITY_CHAT_REMOVED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onPaidMessagesWaived($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::PAID_MESSAGES_WAIVED->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onTonWalletTransfer($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::TON_WALLET_TRANSFER->value][] = new Handler($callable);
    }

    /**
     * @param callable|class-string|array $callable
     */
    public function onWidget($callable, UpdateType $target = UpdateType::MESSAGE): Handler
    {
        $this->checkFinalized();
        $target->validateMessageType();
        return $this->{$this->target}[$target->value][MessageType::WIDGET->value][] = new Handler($callable);
    }
}
