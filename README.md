<p align="center">
  <img src="https://i.imgur.com/0KjYtTJ.png" width="400px">
</p>

# Nutgram

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nutgram/nutgram.svg)](https://packagist.org/packages/nutgram/nutgram)
[![Total Downloads](http://poser.pugx.org/nutgram/nutgram/downloads)](https://packagist.org/packages/nutgram/nutgram)
![GitHub](https://img.shields.io/github/license/nutgram/nutgram)
[![API](https://img.shields.io/badge/Telegram%20Bot%20API-6.7%09--%20April%2021,%202023-blue.svg)](https://core.telegram.org/bots/api)

[![Test Suite](https://github.com/nutgram/nutgram/actions/workflows/php.yml/badge.svg)](https://github.com/nutgram/nutgram/actions/workflows/php.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/86c4ca3dae8f64db80f7/maintainability)](https://codeclimate.com/github/nutgram/nutgram/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/86c4ca3dae8f64db80f7/test_coverage)](https://codeclimate.com/github/nutgram/nutgram/test_coverage)

> The Telegram bot framework that doesn't drive you nuts

This framework takes advantage of the latest **PHP 8** features, and tries to make the **speed**, **scalability** and **flexibility** of use its strength, it will allow you to quickly make simple bots, but at the same time, it provides
more **advanced features** to handle even the most complicated flows. Some architectural concepts on which Nutgram is
based are heavily influenced by other open source projects such as [Botman](https://github.com/botman/botman)
and [Zanzara](https://github.com/badfarm/zanzara), check them out too!

```php
<?php

use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('start', function(Nutgram $bot) {
    $bot->sendMessage('Ciao!');
});

$bot->onText('My name is {name}', function(Nutgram $bot, string $name) {
    $bot->sendMessage("Hi $name");
});

$bot->run();
```

## Installation

You can install the package via composer:

```bash
composer require nutgram/nutgram
```

## Usage

- [Official Documentation](https://nutgram.dev)

## Projects with this library
> Is your project using Nutgram? Let us know, feel free to add yours!

- AnonyMeet ([@AnonyMeetBot](https://t.me/AnonyMeetBot)) - Anonymous chat bot
- File Converter ([@newfileconverterbot](https://t.me/newfileconverterbot)) - Convert files to other formats
- [Sticker Optimizer](https://github.com/Lukasss93/telegram-stickeroptimizer) ([@NewStickerOptimizerBot](https://t.me/NewStickerOptimizerBot)) - Optimize images for the @stickers bot
- Chat Merger ([@ChatMergerBot](https://t.me/ChatMergerBot)) - Merge multiple messages into one
- [Mermaid Generator](https://github.com/Lukasss93/telegram-mermaid) ([@newmermaidbot](https://t.me/newmermaidbot)) - Generate mermaid diagrams from text
- Voice Transcriber ([@voicetranscriberobot](https://t.me/voicetranscriberobot)) - Transcribe audio messages to text
- Effin Birds ([@effinbirdsbot](https://t.me/effinbirdsbot)) - Search and send in inline mode images made by https://twitter.com/EffinBirds

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Sergio Brighenti](https://github.com/SergiX44)
- [Luca Patera](https://github.com/Lukasss93)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
