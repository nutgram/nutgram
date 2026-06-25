<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Utils;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

it('works with StreamInterface', function () {
    $stream = Utils::streamFor('foo');
    $inputFile = new InputFile($stream);

    expect($inputFile)
        ->toBeInstanceOf(InputFile::class)
        ->getFilename()->toBe('temp')
        ->getStream()->getContents()->toBe('foo');
});

it('works with resource', function () {
    $stream = Utils::streamFor('foo')->detach();
    $inputFile = new InputFile($stream);

    expect($inputFile)
        ->toBeInstanceOf(InputFile::class)
        ->getFilename()->toBe('temp')
        ->getStream()->getContents()->toBe('foo');
});

it('works with uri', function () {
    $stream = 'https://placehold.co/400';
    $inputFile = new InputFile($stream);

    expect($inputFile)
        ->toBeInstanceOf(InputFile::class)
        ->getFilename()->toBe('400');
});

it('works with text', function () {
    $inputFile = InputFile::makeFromString('foo');

    expect($inputFile)
        ->toBeInstanceOf(InputFile::class)
        ->getFilename()->toBe('temp')
        ->getStream()->getContents()->toBe('foo');
});

it('works with file path', function () {
    $stream = __DIR__.'/../Fixtures/sample.txt';
    $inputFile = InputFile::make($stream);

    expect($inputFile)
        ->toBeInstanceOf(InputFile::class)
        ->getFilename()->toBe('sample.txt')
        ->getStream()->getContents()->toBe('foo');
});

it('gets the filename and content', function (?string $filename, string $expectedFilename) {
    $stream = __DIR__.'/../Fixtures/sample.txt';
    $inputFile = new InputFile($stream, $filename);

    expect($inputFile->getStream()->getContents())->toBe('foo');
    expect($inputFile->getFilename())->toBe($expectedFilename);
    expect(json_encode($inputFile, JSON_UNESCAPED_SLASHES))->toBe(sprintf('"attach://%s"', $expectedFilename));
})->with([
    'keep' => [null, 'sample.txt'],
    'custom' => ['custom.txt', 'custom.txt'],
]);

it('throws exception for invalid stream', function () {
    InputFile::make('foo');
})->throws(RuntimeException::class, 'Unable to open "foo" using mode "rb": fopen(foo): Failed to open stream: No such file or directory');

it('throws exception for invalid argument', function () {
    InputFile::make(123);
})->throws(InvalidArgumentException::class, 'Invalid stream specified.');
