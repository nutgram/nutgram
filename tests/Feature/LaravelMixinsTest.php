<?php

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Storage;
use SergiX44\Nutgram\Laravel\Mixins\FileMixin;
use SergiX44\Nutgram\Laravel\Mixins\NutgramMixin;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

test('the Nutgram::downloadFileToDisk method save File to Laravel disk', function () {
    Nutgram::mixin(new NutgramMixin());

    $disk = 'local';
    $storedFileName = 'text.txt';
    $storedFileContent = 'Hello World';

    Storage::fake($disk);

    $bot = Nutgram::fake(responses: [
        new Response(200, body: $storedFileContent),
    ]);

    $file = new File($bot);
    $file->file_id = 'foo';
    $file->file_unique_id = 'foobar';
    $file->file_size = 123456;
    $file->file_path = 'foo/bar.txt';

    $bot->downloadFileToDisk($file, $storedFileName, $disk);

    Storage::disk($disk)->assertExists($storedFileName, $storedFileContent);
});

test('the File::saveToDisk method save File to Laravel disk', function () {
    File::mixin(new FileMixin());

    $disk = 'local';
    $storedFileName = 'text.txt';
    $storedFileContent = 'Hello World';

    Storage::fake($disk);

    $bot = Nutgram::fake(responses: [
        new Response(200, body: $storedFileContent),
    ]);

    $file = new File($bot);
    $file->file_id = 'foo';
    $file->file_unique_id = 'foobar';
    $file->file_size = 123456;
    $file->file_path = 'foo/bar.txt';

    $file->saveToDisk($storedFileName, $disk);

    Storage::disk($disk)->assertExists($storedFileName, $storedFileContent);
});
