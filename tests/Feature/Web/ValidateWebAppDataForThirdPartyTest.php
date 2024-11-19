<?php

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Web\WebAppData;
use SergiX44\Nutgram\Telegram\Web\WebAppUser;

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
    $botId = 134679134;
    $bot = Nutgram::fake(config: new Configuration(botId: $botId));
    [$initData, $publicKey] = $bot->generateWebAppDataForThirdParty($botId, $this->input);

    $data = $bot->validateWebAppDataForThirdParty($initData, $publicKey);

    expect($data)->toBeInstanceOf(WebAppData::class);
    expect($data->user)->toBeInstanceOf(WebAppUser::class);
});

it('fails to validate webapp data for third-party use', function () {
    $botId = 134679134;
    $bot = Nutgram::fake(config: new Configuration(botId: $botId));
    [$initData, $publicKey] = $bot->generateWebAppDataForThirdParty($botId, $this->input);

    $publicKey = '0000000000000000000000000000000000000000000000000000000000000000';

    $bot->validateWebAppDataForThirdParty($initData, $publicKey);
})->throws(InvalidDataException::class, 'Invalid webapp data');