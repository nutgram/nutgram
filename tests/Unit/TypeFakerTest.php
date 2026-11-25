<?php

declare(strict_types=1);

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockCollage;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockSectionHeading;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockPullQuotation;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextBold;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\Widget\SharedWidgetQuery;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryType;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryTypeData;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryTypeSignData;
use SergiX44\Nutgram\Testing\TypeFaker;

it('fakes an interface using its concrete resolver', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    expect($faker->fakeInstanceOf(WidgetQueryType::class))
        ->toBeInstanceOf(WidgetQueryTypeData::class);
});

it('fakes a required interface property', function (array $partial, string $expected) {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    $query = $faker->fakeInstanceOf(SharedWidgetQuery::class, $partial);

    expect($query->type)->toBeInstanceOf($expected);
})->with([
    'default concrete type' => [[], WidgetQueryTypeData::class],
    'explicit concrete type' => [['type' => ['type' => 'sign_data']], WidgetQueryTypeSignData::class],
]);

it('terminates automatically generated recursive rich text arrays', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    $text = $faker->fakeInstanceOf(RichTextBold::class);

    expect($text->text)->toHaveCount(1)
        ->and($text->text[0])->toBeInstanceOf(RichTextBold::class)
        ->and($text->text[0]->text)->toBe([]);
});

it('preserves explicitly supplied recursive rich text', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    $text = $faker->fakeInstanceOf(RichTextBold::class, [
        'text' => [
            [
                'type' => 'bold',
                'text' => [
                    ['type' => 'bold', 'text' => 'leaf'],
                ],
            ],
        ],
    ]);

    expect($text->text[0])->toBeInstanceOf(RichTextBold::class)
        ->and($text->text[0]->text[0])->toBeInstanceOf(RichTextBold::class)
        ->and($text->text[0]->text[0]->text)->toBe('leaf');
});

it('generates the same type in separate sibling properties', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    $quotation = $faker->fakeInstanceOf(RichBlockPullQuotation::class, ['credit' => []]);

    expect($quotation->text)->toHaveCount(1)
        ->and($quotation->credit)->toHaveCount(1)
        ->and($quotation->credit[0])->toBeInstanceOf(RichTextBold::class);
});

it('uses the resolved scalar type even when the property has an ArrayType attribute', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    expect($faker->fakeInstanceOf(InputRichBlockSectionHeading::class)->text)->toBeString();
});

it('leaves generated arrays empty when their interface has no concrete resolver', function () {
    $faker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    expect($faker->fakeInstanceOf(InputRichBlockCollage::class)->blocks)->toBe([]);
});

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

it('gets message from replied message', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('hello', function (Nutgram $bot) {
        $reply = $bot->message()->reply_to_message;

        expect($reply)->toBeInstanceOf(Message::class)
            ->and($reply->text)->toBe('moto');
    });

    $bot
        ->hearMessage([
            'text' => '/hello',
            'reply_to_message' => [
                'from' => User::make(123456, false, 'Noob')->toArray(),
                'chat' => Chat::make(654321, ChatType::GROUP)->toArray(),
                'text' => 'moto',
            ],
        ])
        ->reply();
});
