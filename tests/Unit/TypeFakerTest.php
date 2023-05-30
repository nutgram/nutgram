<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

it('can create my chat member status', function () {
    Nutgram::fake()
        ->hearUpdateType(UpdateType::MY_CHAT_MEMBER, [
            'chat' => ['id' => 321],
            'from' => ['id' => 321],
            'new_chat_member' => ['status' => ChatMemberStatus::MEMBER->value],
        ])
        ->reply()
        ->assertNoReply();
});

it('get user profile photos with specified file ids', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $result = $bot->getUserProfilePhotos(123);

        expect($result)
            ->total_count->toBe(2)
            ->photos->toBeArray()
            ->photos->toHaveCount(2)
            ->and($result->photos[0])->toBeArray()
            ->sequence(
                fn ($item) => $item->toBeInstanceOf(PhotoSize::class)->file_id->toBe('1A'),
                fn ($item) => $item->toBeInstanceOf(PhotoSize::class)->file_id->toBe('1B'),
            )
            ->and($result->photos[1])->toBeArray()
            ->sequence(
                fn ($item) => $item->toBeInstanceOf(PhotoSize::class)->file_id->toBe('2A'),
                fn ($item) => $item->toBeInstanceOf(PhotoSize::class)->file_id->toBe('2B'),
            );
    });

    $bot
        ->hearText('/start')
        ->willReceivePartial([
            'total_count' => 2,
            'photos' => [
                [
                    ['file_id' => '1A'],
                    ['file_id' => '1B'],
                ],
                [
                    ['file_id' => '2A'],
                    ['file_id' => '2B'],
                ]
            ]
        ])
        ->reply()
        ->assertReply('getUserProfilePhotos', [
            'user_id' => 123,
        ]);
});

it('get user profile photos with default', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $result = $bot->getUserProfilePhotos(123);

        expect($result)
            ->total_count->toBe(2)
            ->photos->toBeArray()
            ->photos->toHaveCount(1)
            ->and($result->photos[0])->toBeArray()
            ->sequence(
                fn ($item) => $item->toBeInstanceOf(PhotoSize::class),
            );
    });

    $bot
        ->hearText('/start')
        ->willReceivePartial([
            'total_count' => 2,
        ])
        ->reply()
        ->assertReply('getUserProfilePhotos', [
            'user_id' => 123,
        ]);
});
