<?php

declare(strict_types=1);

use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichMessageMedia;

it('maps uploadable property names to their current values', function () {
    $file = InputFile::makeFromString('video', 'video.mp4');
    $video = new InputMediaVideo(media: $file, cover: 'cover-file-id');

    expect($video->uploadables())->toBe([
        'media' => $file,
        'thumbnail' => null,
        'cover' => 'cover-file-id',
    ]);
});

it('returns null for an uninitialized rich message media property', function () {
    expect((new InputRichMessageMedia())->uploadables())->toBe(['media' => null]);
});
