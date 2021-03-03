<p class="text-center">
  <img src="https://i.imgur.com/0KjYtTJ.png" width="400px">
</p>
<hr>
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sergix44/nutgram.svg?style=flat-square)](https://packagist.org/packages/sergix44/nutgram)
[![Test Suite](https://github.com/SergiX44/Nutgram/actions/workflows/php.yml/badge.svg)](https://github.com/SergiX44/Nutgram/actions/workflows/php.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/sergix44/nutgram.svg?style=flat-square)](https://packagist.org/packages/sergix44/nutgram)

> The Telegram bot library that doesn't drive you nuts

This framework takes advantage of the latest PHP 8 features, and tries to make the **speed**, **scalability** and **
flexibility** of use its strength, it will allow you to quickly make simple bots, but at the same time, it provides
more **advanced features** to handle even the most complicated flows. Some of the architectural concepts on which
Nutgram is based are heavily influenced by other open source projects such as [Botman](https://github.com/botman/botman)
and [Zanzara](https://github.com/badfarm/zanzara), check them out too!

```php
<?php

use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Ciao!');
});

$bot->onText('My name is {name}', function (Nutgram $bot, $name) {
    $bot->sendMessage("Hi {$name}");
});

$bot->run();
```