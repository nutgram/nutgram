<?php

use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Web\WebAppData;

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
        'chat_instance' => '-123456789',
        'chat_type' => 'private',
        'start_param' => 'foo',
        'auth_date' => '1234567890',
    ];
});

it('validates login data', function () {
    $bot = Nutgram::fake();
    $queryString = $bot->generateWebAppData($this->input);
    $data = $bot->validateWebAppData($queryString);
    expect($data)->toBeInstanceOf(WebAppData::class);
});

it('fails to validate login data', function () {
    $bot = Nutgram::fake();
    $queryString = $bot->generateWebAppData($this->input);
    $queryString = str_replace('start_param=foo', 'start_param=bar', $queryString);
    $bot->validateWebAppData($queryString);
})->throws(InvalidDataException::class);
