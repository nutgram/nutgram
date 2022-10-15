<?php

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Storage;
use SergiX44\Nutgram\Laravel\Mixins\FileMixin;
use SergiX44\Nutgram\Laravel\Mixins\NutgramMixin;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

test(
    'the Nutgram::downloadFileToDisk method save File to Laravel disk',
    function ($originalFileName, $storedFileName, $assertStoredFileName) {
        Nutgram::mixin(new NutgramMixin());

        $disk = 'local';
        $originalFileContent = 'Hello World';

        Storage::fake($disk);
        Storage::disk($disk)->makeDirectory('texts');

        $bot = Nutgram::fake(responses: [
            new Response(200, body: $originalFileContent),
        ]);

        $file = new File($bot);
        $file->file_id = 'foo';
        $file->file_unique_id = 'foobar';
        $file->file_size = 123456;
        $file->file_path = $originalFileName;

        $bot->downloadFileToDisk($file, $storedFileName, $disk);

        Storage::disk($disk)->assertExists($assertStoredFileName, $originalFileContent);
    }
)->with([
    'full_path' => ['foo/bar.txt', 'text.txt', 'text.txt'],
    'dir_path' => ['foo/bar.txt', 'texts/', 'texts/bar.txt'],
]);

test(
    'the File::saveToDisk method save File to Laravel disk',
    function ($originalFileName, $storedFileName, $assertStoredFileName) {
        File::mixin(new FileMixin());

        $disk = 'local';
        $originalFileContent = 'Hello World';

        Storage::fake($disk);
        Storage::disk($disk)->makeDirectory('texts');

        $bot = Nutgram::fake(responses: [
            new Response(200, body: $originalFileContent),
        ]);

        $file = new File($bot);
        $file->file_id = 'foo';
        $file->file_unique_id = 'foobar';
        $file->file_size = 123456;
        $file->file_path = $originalFileName;

        $file->saveToDisk($storedFileName, $disk);

        Storage::disk($disk)->assertExists($assertStoredFileName, $originalFileContent);
    }
)->with([
    'full_path' => ['foo/bar.txt', 'text.txt', 'text.txt'],
    'dir_path' => ['foo/bar.txt', 'texts/', 'texts/bar.txt'],
]);
