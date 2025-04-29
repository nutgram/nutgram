<?php

declare(strict_types=1);

use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Web\WebAppData;
use SergiX44\Nutgram\Telegram\Web\WebAppUser;
use SergiX44\Nutgram\Testing\FakeNutgram;

beforeEach(function () {
    $this->input = [
        'user' => json_encode([
            'id' => 987654321,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'john_doe',
            'language_code' => 'en',
            'is_premium' => true,
            'allows_write_to_pm' => true,
        ], JSON_THROW_ON_ERROR),
        'query_id' => 'AAHQ05kAAAAAANDTmQBGqXTa',
        'auth_date' => '1234567890',
    ];
})->skip(!extension_loaded('sodium'), 'Sodium extension is required');

it('validates webapp data for third-party use', function () {
    [$initData, $publicKey] = FakeNutgram::generateWebAppDataForThirdParty(
        botId: 134679134,
        data: $this->input,
    );

    $data = Nutgram::validateWebAppDataForThirdParty(
        botId: 134679134,
        queryString: $initData,
        publicKey: $publicKey,
    );

    expect($data)->toBeInstanceOf(WebAppData::class);
    expect($data->user)->toBeInstanceOf(WebAppUser::class);
});

it('fails to validate webapp data for third-party use', function () {
    [$initData, $publicKey] = FakeNutgram::generateWebAppDataForThirdParty(
        botId: 134679134,
        data: $this->input,
    );

    Nutgram::validateWebAppDataForThirdParty(
        botId: 999999999,
        queryString: $initData,
        publicKey: $publicKey,
    );
})->throws(InvalidDataException::class, 'Invalid webapp data');
