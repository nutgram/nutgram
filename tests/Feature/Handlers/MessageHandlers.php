<?php

use SergiX44\Nutgram\Nutgram;

it('calls onText() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onCommand() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('command');

it('calls onCommand() handler with different tags', function ($update, $valid) {
    $bot = Nutgram::fake($update, config: ['bot_name' => 'foo']);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called', false))->toBe($valid);
})->with('command_tags');

it('calls onAnimation() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAnimation(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('animation');

it('calls onAudio() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAudio(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('audio');

it('calls onDocument() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onDocument(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('document');

it('calls onPhoto() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onPhoto(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('photo');

it('calls onSticker() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onSticker(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('sticker');

it('calls onVideo() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVideo(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('video');

it('calls onVideoNote() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVideoNote(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('video_note');

it('calls onVoice() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onVoice(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('voice');

it('calls onContact() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onContact(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('contact');

it('calls onDice() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onDice(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('dice');

it('calls onSuccessfulPayment() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPayment(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onSuccessfulPaymentPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPaymentPayload('thedata', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onForumTopicCreated handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicCreated(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_created');

it('calls onForumTopicClosed handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicClosed(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_closed');

it('calls onForumTopicReopened handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicReopened(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_reopened');