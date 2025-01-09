<?php

declare(strict_types=1);

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

it('calls onText() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls onText() handler as channel_post', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->set('called', true);
    }, UpdateType::CHANNEL_POST);

    $bot->run();

    expect($bot->get('called', false))->toBeTrue();
})->with('channel_post');

it('calls onCommand() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('command');

it('calls onCommand() handler with different tags', function ($update, $valid) {
    $bot = Nutgram::fake($update, config: new Configuration(botName: 'foo_bot'));
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called', false))->toBe($valid);
})->with('command_tags');

it('calls onAnimation() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAnimation(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('animation');

it('calls onAudio() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAudio(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('audio');

it('calls onDocument() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onDocument(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('document');

it('calls onPhoto() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onPhoto(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('photo');

it('calls onSticker() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onSticker(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('sticker');

it('calls onVideo() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVideo(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video');

it('calls onVideoNote() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVideoNote(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video_note');

it('calls onVoice() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVoice(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('voice');

it('calls onContact() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onContact(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('contact');

it('calls onDice() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onDice(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('dice');

it('calls onGame() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onGame(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('game');

it('calls onMessagePoll() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessagePoll(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_poll');

it('calls onVenue() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVenue(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('venue');

it('calls onLocation() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onLocation(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('location');

it('calls onStory() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onStory(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('story');

it('calls onNewChatMembers() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onNewChatMembers(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('new_chat_members');

it('calls onLeftChatMember() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onLeftChatMember(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('left_chat_member');

it('calls onNewChatTitle() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onNewChatTitle(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('new_chat_title');

it('calls onNewChatPhoto() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onNewChatPhoto(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('new_chat_photo');

it('calls onDeleteChatPhoto() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onDeleteChatPhoto(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('delete_chat_photo');

it('calls onGroupChatCreated() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onGroupChatCreated(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('group_chat_created');

it('calls onSupergroupChatCreated() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onSupergroupChatCreated(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('supergroup_chat_created');

it('calls onChannelChatCreated() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onChannelChatCreated(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('channel_chat_created');

it('calls onMessageAutoDeleteTimerChanged() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessageAutoDeleteTimerChanged(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_auto_delete_timer_changed');

it('calls onMigrateToChatId() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMigrateToChatId(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('migrate_to_chat_id');

it('calls onMigrateFromChatId() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMigrateFromChatId(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('migrate_from_chat_id');

it('calls onPinnedMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onPinnedMessage(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('pinned_message');

it('calls onInvoice() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onInvoice(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('invoice');

it('calls onSuccessfulPayment() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPayment(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('successful_payment');

it('calls onSuccessfulPaymentPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPaymentPayload('thedata', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('successful_payment');

it('calls onRefundedPayment() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onRefundedPayment(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('refunded_payment');

it('calls onRefundedPaymentPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onRefundedPaymentPayload('thedata', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('refunded_payment');

it('calls onUsersShared() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onUsersShared(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('users_shared');

it('calls onChatShared() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatShared(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chat_shared');

it('calls onGiveawayCreated() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onGiveawayCreated(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('giveaway_created');

it('calls onGiveaway() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onGiveaway(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('giveaway');

it('calls onGiveawayWinners() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onGiveawayWinners(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('giveaway_winners');

it('calls onGiveawayCompleted() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onGiveawayCompleted(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('giveaway_completed');

it('calls onConnectedWebsite() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onConnectedWebsite(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('connected_website');

it('calls onPassportData() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPassportData(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('passport_data');

it('calls onProximityAlertTriggered() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onProximityAlertTriggered(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('proximity_alert_triggered');

it('calls onBoostAdded() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onBoostAdded(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_boost_added');

it('calls onForumTopicCreated handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicCreated(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('forum_topic_created');

it('calls onForumTopicEdited handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicEdited(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('forum_topic_edited');

it('calls onForumTopicClosed handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicClosed(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('forum_topic_closed');

it('calls onForumTopicReopened handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicReopened(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('forum_topic_reopened');

it('calls onVideoChatScheduled handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onVideoChatScheduled(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video_chat_scheduled');

it('calls onVideoChatStarted handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onVideoChatStarted(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video_chat_started');

it('calls onVideoChatEnded handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onVideoChatEnded(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video_chat_ended');

it('calls onVideoChatParticipantsInvited handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onVideoChatParticipantsInvited(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('video_chat_participants_invited');

it('calls onWebAppData handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onWebAppData(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('web_app_data');
