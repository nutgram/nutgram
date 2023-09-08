<?php

use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Web\LoginData;

beforeEach(function () {
    $this->input = [
        'id' => '987654321',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'john_doe',
        'auth_date' => '1234567890',
    ];
});

it('validates login data', function () {
    $bot = Nutgram::fake();
    $queryString = $bot->generateLoginData($this->input);
    $data = $bot->validateLoginData($queryString);
    expect($data)->toBeInstanceOf(LoginData::class);
});

it('fails to validate login data', function () {
    $bot = Nutgram::fake();
    $queryString = $bot->generateLoginData($this->input);
    $queryString = str_replace('id=987654321', 'id=123456789', $queryString);
    $bot->validateLoginData($queryString);
})->throws(InvalidDataException::class);
