<?php

use GuzzleHttp\Psr7\Utils;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

it('returns filename with in memory file', function () {
    $f = fopen('php://memory', 'rwb+');
    fwrite($f, 'hi!');
    $inputFile = new InputFile($f);

    expect($inputFile->getFilename())->toBe('memory');
});

it('returns filename with stream', function () {
    $f = Utils::streamFor('test')->detach();
    $inputFile = new InputFile($f);

    expect($inputFile->getFilename())->toBe('temp');
});

it('returns custom filename if set', function () {
    $f = Utils::streamFor('test')->detach();
    $inputFile = new InputFile($f, 'name.txt');

    expect($inputFile->getFilename())->toBe('name.txt');
});

it('works for filesystem files and custom name', function () {
    $f = fopen(__DIR__.'/../Updates/command.json', 'rb+');
    $inputFile = new InputFile($f, 'name.txt');

    expect($inputFile->getFilename())->toBe('name.txt');
});

it('works for filesystem files', function () {
    $f = fopen(__DIR__.'/../Updates/command.json', 'rb+');
    $inputFile = new InputFile($f);

    expect($inputFile->getFilename())->toBe('command.json');
});

it('throws exception for invalid resources', function () {
    $f = 'a string';
    $inputFile = new InputFile($f);
})->throws(InvalidArgumentException::class);
