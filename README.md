<p class="text-center">
  <img src="https://i.imgur.com/ttzg3qk.png" width="400px">
</p>

# Nutgram

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sergix44/nutgram.svg?style=flat-square)](https://packagist.org/packages/sergix44/nutgram)
[![Test Suite](https://github.com/SergiX44/Nutgram/actions/workflows/php.yml/badge.svg)](https://github.com/SergiX44/Nutgram/actions/workflows/php.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/sergix44/nutgram.svg?style=flat-square)](https://packagist.org/packages/sergix44/nutgram)

> The Telegram bot library that doesn't drive you nuts

## Installation

You can install the package via composer:

```bash
composer require sergix44/nutgram
```

## Usage

```php
$bot = new Sergix44\Nutgram('telegram-token-xxx');
echo $bot->sendMessage('hi!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sergio Brighenti](https://github.com/SergiX44)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
