<?php

use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

it('hydrate rich_message', function ($content) {
    $hydrator = Nutgram::fake()->getContainer()->get(Hydrator::class);

    $result = $hydrator->hydrate($content, Message::class);

    expect($result)->toBeInstanceOf(Message::class);
})->with('message.rich_message');

it('hydrates rich_message with photo, video, and animation blocks without has_spoiler', function () {
    $hydrator = Nutgram::fake()->getContainer()->get(Hydrator::class);

    $payload = [
        'message_id' => 1234,
        'date' => 1784483903,
        'chat' => [
            'id' => 12345678,
            'type' => 'private',
        ],
        'rich_message' => [
            'blocks' => [
                [
                    'type' => 'photo',
                    'photo' => [
                        [
                            'file_id' => 'photo_123',
                            'file_unique_id' => 'u_123',
                            'width' => 100,
                            'height' => 100,
                        ],
                    ],
                ],
                [
                    'type' => 'video',
                    'video' => [
                        'file_id' => 'video_123',
                        'file_unique_id' => 'u_vid_123',
                        'width' => 100,
                        'height' => 100,
                        'duration' => 10,
                    ],
                ],
                [
                    'type' => 'animation',
                    'animation' => [
                        'file_id' => 'anim_123',
                        'file_unique_id' => 'u_anim_123',
                        'width' => 100,
                        'height' => 100,
                        'duration' => 5,
                    ],
                ],
            ],
        ],
    ];

    /** @var Message $result */
    $result = $hydrator->hydrate($payload, Message::class);

    expect($result)->toBeInstanceOf(Message::class)
        ->and($result->rich_message->blocks)->toHaveCount(3)
        ->and($result->rich_message->blocks[0])->toBeInstanceOf(\SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockPhoto::class)
        ->and($result->rich_message->blocks[0]->has_spoiler)->toBeNull()
        ->and($result->rich_message->blocks[1])->toBeInstanceOf(\SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockVideo::class)
        ->and($result->rich_message->blocks[1]->has_spoiler)->toBeNull()
        ->and($result->rich_message->blocks[2])->toBeInstanceOf(\SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockAnimation::class)
        ->and($result->rich_message->blocks[2]->has_spoiler)->toBeNull();
});

it('hydrates chat boost source premium without user', function () {
    $hydrator = Nutgram::fake()->getContainer()->get(Hydrator::class);

    $payload = [
        'source' => 'premium',
    ];

    /** @var \SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourcePremium $result */
    $result = $hydrator->hydrate($payload, \SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourcePremium::class);

    expect($result)->toBeInstanceOf(\SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourcePremium::class)
        ->and($result->user)->toBeNull();
});
