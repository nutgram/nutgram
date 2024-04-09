<?php

use SergiX44\Nutgram\Support\DeepLink;
use function SergiX44\Nutgram\Support\deepLink;

it('can be instantiated statically', function () {
    $deepLink = DeepLink::make();
    expect($deepLink)->toBeInstanceOf(DeepLink::class);
});

it('can be used via helper function', function () {
    $deepLink = deepLink();
    expect($deepLink)->toBeInstanceOf(DeepLink::class);
});

it('can create a deep link to a username', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->username('FooUser');
    expect($link)->toBe('https://t.me/FooUser');
});

it('can create a deep link to a contact', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->contact('A1B2C3D4E5');
    expect($link)->toBe('https://t.me/contact/A1B2C3D4E5');
});

it('can create a deep link to a phone number', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->phone(39, 1234567890);
    expect($link)->toBe('https://t.me/+391234567890');
});

it('can create a deep link to a private chat', function (string $hash, bool $legacy, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->joinChat($hash, $legacy);
    expect($link)->toBe($expected);
})->with([
    'default' => ['A1B2C3D4E5', false, 'https://t.me/+A1B2C3D4E5'],
    'legacy' => ['A1B2C3D4E5', true, 'https://t.me/joinchat/A1B2C3D4E5'],
]);

it('can create a deep link to a list', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->addList('A1B2C3D4E5');
    expect($link)->toBe('https://t.me/addlist/A1B2C3D4E5');
});

it('can create a deep link to a public message', function (?int $threadId, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->publicMessage(
        username: 'FooUser',
        messageId: 123,
        threadId: $threadId,
        single: true,
        comment: 123456,
        mediaTimestamp: '15'
    );
    expect($link)->toBe($expected);
})->with([
    'with thread id' => [1, 'https://t.me/FooUser/1/123?single&comment=123456&t=15'],
    'no thread id' => [null, 'https://t.me/FooUser/123?single&comment=123456&t=15'],
]);

it('can create a deep link to a private message', function (?int $threadId, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->privateMessage(
        chatId: 987654,
        messageId: 123,
        threadId: $threadId,
        single: true,
        comment: 123456,
        mediaTimestamp: '15'
    );
    expect($link)->toBe($expected);
})->with([
    'with thread id' => [1, 'https://t.me/c/987654/1/123?single&comment=123456&t=15'],
    'no thread id' => [null, 'https://t.me/c/987654/123?single&comment=123456&t=15'],
]);

it('can create a deep link to a public forum topic', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->publicForumTopic('FooUser', 123);
    expect($link)->toBe('https://t.me/FooUser/123');
});

it('can create a deep link to a private forum topic', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->privateForumTopic(987654, 123);
    expect($link)->toBe('https://t.me/c/987654/123');
});

it('can create a deep link to a share link', function (string $url, ?string $title, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->share($url, $title);
    expect($link)->toBe($expected);
})->with([
    'with title' => ['https://example.com', 'Example', 'https://t.me/share?url=https%3A%2F%2Fexample.com&text=Example'],
    'no title' => ['https://example.com', null, 'https://t.me/share?url=https%3A%2F%2Fexample.com'],
]);

it('can create a deep link to a videochat', function (string $hash, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->videochat('foo', $hash);
    expect($link)->toBe($expected);
})->with([
    'default' => ['', 'https://t.me/foo?videochat'],
    'with hash' => ['A1B2C3D4E5', 'https://t.me/foo?videochat=A1B2C3D4E5'],
]);

it('can create a deep link to a livestream', function (string $hash, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->livestream('foo', $hash);
    expect($link)->toBe($expected);
})->with([
    'default' => ['', 'https://t.me/foo?livestream'],
    'with hash' => ['A1B2C3D4E5', 'https://t.me/foo?livestream=A1B2C3D4E5'],
]);

it('can create a deep link to a stickerset', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->addStickers('FooStickers');
    expect($link)->toBe('https://t.me/addstickers/FooStickers');
});

it('can create a deep link to a emojiset', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->addEmoji('FooEmoji');
    expect($link)->toBe('https://t.me/addemoji/FooEmoji');
});

it('can create a deep link to a story', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->story('FooUser', 123);
    expect($link)->toBe('https://t.me/FooUser/s/123');
});

it('can create a deep link to a public boost', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->publicBoost('FooUser');
    expect($link)->toBe('https://t.me/boost/FooUser');
});

it('can create a deep link to a private boost', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->privateBoost(987654);
    expect($link)->toBe('https://t.me/boost?c=987654');
});

it('can create a deep link to a proxy (MTProxy)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->proxyMTP('foo', 123, 'bar');
    expect($link)->toBe('https://t.me/proxy?server=foo&port=123&secret=bar');
});

it('can create a deep link to a proxy (Socks5)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->proxySocks5('foo', 123, 'us', 'pa');
    expect($link)->toBe('https://t.me/socks?server=foo&port=123&user=us&pass=pa');
});

it('can create a deep link to a theme', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->addTheme('foo');
    expect($link)->toBe('https://t.me/addtheme/foo');
});

it('can create a deep link to a wallpaper (image)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperImage('foo', ['blur', 'motion']);
    expect($link)->toBe('https://t.me/bg/foo?mode=blur+motion');
});

it('can create a deep link to a wallpaper (solid fill)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperSolidFill('FF0000');
    expect($link)->toBe('https://t.me/bg/FF0000');
});

it('can create a deep link to a wallpaper (gradient fill)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperGradientFill('FF0000', '00FF00', 90);
    expect($link)->toBe('https://t.me/bg/FF0000-00FF00?rotation=90');
});

it('can create a deep link to a wallpaper (freeform gradient fill)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperFreeformGradientFill(
        hexColor1: 'FF0000',
        hexColor2: '00FF00',
        hexColor3: '0000FF',
        hexColor4: 'FFFF00',
    );
    expect($link)->toBe('https://t.me/bg/FF0000~00FF00~0000FF~FFFF00');
});

it('can create a deep link to a wallpaper (solid pattern)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperSolidPattern(
        slug: 'foo',
        intensity: 100,
        bgColor: 'FF0000',
        mode: ['motion'],
    );
    expect($link)->toBe('https://t.me/bg/foo?intensity=100&bg_color=FF0000&mode=motion');
});

it('can create a deep link to a wallpaper (gradient pattern)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperGradientPattern(
        slug: 'foo',
        intensity: 100,
        topColor: 'FF0000',
        bottomColor: '00FF00',
        rotation: 90,
        mode: ['motion'],
    );
    expect($link)->toBe('https://t.me/bg/foo?intensity=100&top_color=FF0000&bottom_color=00FF00&rotation=90&mode=motion');
});

it('can create a deep link to a wallpaper (freeform gradient pattern)', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->wallpaperFreeformGradientPattern(
        slug: 'foo',
        intensity: 100,
        hexColor1: 'FF0000',
        hexColor2: '00FF00',
        hexColor3: '0000FF',
        hexColor4: 'FFFF00',
        mode: ['motion'],
    );
    expect($link)->toBe('https://t.me/bg/foo?intensity=100&bg_color=FF0000~00FF00~0000FF~FFFF00&mode=motion');
});

it('can create a deep link to a bot start parameter', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->start('foobot', 'bar');
    expect($link)->toBe('https://t.me/foobot?start=bar');
});

it('can create a deep link to add a bot to group', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->startGroup(
        botUsername: 'foobot',
        value: 'bar',
        admin: ['change_info', 'post_messages'],
    );
    expect($link)->toBe('https://t.me/foobot?startgroup=bar&admin=change_info+post_messages');
});

it('can create a deep link to add a bot to channel', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->startChannel(
        botUsername: 'foobot',
        admin: ['change_info', 'post_messages'],
    );
    expect($link)->toBe('https://t.me/foobot?startchannel&admin=change_info+post_messages');
});

it('can create a deep link to game', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->game('foobot', 'bar');
    expect($link)->toBe('https://t.me/foobot?game=bar');
});

it('can create a deep link to login', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->login('foobar');
    expect($link)->toBe('https://t.me/login/foobar');
});

it('can create a deep link to invoice', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->invoice('foobar');
    expect($link)->toBe('https://t.me/invoice/foobar');
});

it('can create a deep link to language', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->setLanguage('en');
    expect($link)->toBe('https://t.me/setlanguage/en');
});

it('can create a deep link to confirm phone', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->confirmPhone('1234567890', 'foo');
    expect($link)->toBe('https://t.me/confirmphone?phone=1234567890&hash=foo');
});

it('can create a deep link to gift code', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->giftCode('foo');
    expect($link)->toBe('https://t.me/giftcode/foo');
});

it('can create a deep link to startapp', function (string $value, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->startApp('foobot', $value);
    expect($link)->toBe($expected);
})->with([
    'default' => ['', 'https://t.me/foobot?startapp'],
    'with value' => ['bar', 'https://t.me/foobot?startapp=bar'],
]);

it('can create a deep link to mini app', function (?string $param, string $expected) {
    $deepLink = new DeepLink();
    $link = $deepLink->miniApp(
        botUsername: 'foobot',
        appName: 'miniapp',
        startParameter: $param
    );
    expect($link)->toBe($expected);
})->with([
    'default' => [null, 'https://t.me/foobot/miniapp'],
    'with value' => ['bar', 'https://t.me/foobot/miniapp?startapp=bar'],
]);

it('can create a deep link to startattach', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->startAttach(
        botUsername: 'foobot',
        startParameter: 'bar',
        choose: ['users', 'bots']
    );
    expect($link)->toBe('https://t.me/foobot?startattach=bar&choose=users+bots');
});

it('can create a deep link to attach', function () {
    $deepLink = new DeepLink();
    $link = $deepLink->attach(
        usernameOrPhone: 'foouser',
        botUsername: 'barbot',
        startParameter: 'baz'
    );
    expect($link)->toBe('https://t.me/foouser?attach=barbot&startattach=baz');
});
