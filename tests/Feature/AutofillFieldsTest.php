<?php

use GuzzleHttp\Psr7\Request;
use SergiX44\Nutgram\Nutgram;

describe('message_thread_id', function () {
    test('not autofilled in general topic message', function ($update) {
        $bot = Nutgram::fake($update);

        $bot->onMessage(function (Nutgram $bot) {
            $bot->sendMessage('Hello');
        });

        $bot->run();

        $bot->assertRaw(function (Request $request) {
            $body = json_decode($request->getBody()->getContents(), true);
            return !array_key_exists('message_thread_id', $body);
        }, message: 'message_thread_id should not be autofilled');
    })->with('message_general_topic');

    test('not autofilled in general topic reply message', function ($update) {
        $bot = Nutgram::fake($update);

        $bot->onMessage(function (Nutgram $bot) {
            $bot->sendMessage('Hello');
        });

        $bot->run();

        $bot->assertRaw(function (Request $request) {
            $body = json_decode($request->getBody()->getContents(), true);
            return !array_key_exists('message_thread_id', $body);
        }, message: 'message_thread_id should not be autofilled');
    })->with('message_general_topic_reply');

    test('autofilled in different topic message', function ($update) {
        $bot = Nutgram::fake($update);

        $bot->onMessage(function (Nutgram $bot) {
            $bot->sendMessage('Hello');
        });

        $bot->run();

        $bot->assertRaw(function (Request $request) {
            $body = json_decode($request->getBody()->getContents(), true);
            return array_key_exists('message_thread_id', $body);
        }, message: 'message_thread_id should be autofilled');
    })->with('message_different_topic');

    test('autofilled in different topic reply message', function ($update) {
        $bot = Nutgram::fake($update);

        $bot->onMessage(function (Nutgram $bot) {
            $bot->sendMessage('Hello');
        });

        $bot->run();

        $bot->assertRaw(function (Request $request) {
            $body = json_decode($request->getBody()->getContents(), true);
            return array_key_exists('message_thread_id', $body);
        }, message: 'message_thread_id should be autofilled');
    })->with('message_different_topic_reply');
});
