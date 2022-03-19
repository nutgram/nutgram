<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Testing\FakeNutgram;

test('the Nutgram::downloadFileToDisk method save File to Laravel disk', function () {

    $disk = 'local';
    $storedFileName = 'text.txt';
    $storedFileContent = 'Hello World';

    Storage::fake($disk);
    Http::fake(['*' => Http::response($storedFileContent)]);

    /** @var FakeNutgram $bot */
    $bot = $this->partialMock(FakeNutgram::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('downloadUrl')
            ->andReturn('https://foo.bar/foo/bar.txt');
    });

    $file = new File($bot);
    $file->file_id = 'foo';
    $file->file_unique_id = 'foobar';
    $file->file_size = 123456;
    $file->file_path = 'foo/bar.txt';

    $bot->downloadFileToDisk($file, $storedFileName, $disk);

    Http::assertSentCount(1);
    Storage::disk($disk)->assertExists($storedFileName, $storedFileContent);
});

test('the File::saveToDisk method save File to Laravel disk', function () {

    $disk = 'local';
    $storedFileName = 'text.txt';
    $storedFileContent = 'Hello World';

    Storage::fake($disk);
    Http::fake(['*' => Http::response($storedFileContent)]);

    /** @var FakeNutgram $bot */
    $bot = $this->partialMock(FakeNutgram::class, function (MockInterface $mock) {
        $mock
            ->shouldReceive('downloadUrl')
            ->andReturn('https://foo.bar/foo/bar.txt');
    });

    $file = new File($bot);
    $file->file_id = 'foo';
    $file->file_unique_id = 'foobar';
    $file->file_size = 123456;
    $file->file_path = 'foo/bar.txt';
    $file->saveToDisk($storedFileName, $disk);

    Http::assertSentCount(1);
    Storage::disk($disk)->assertExists($storedFileName, $storedFileContent);
});
