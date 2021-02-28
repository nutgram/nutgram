---
sort: 1
---

# Installation

You can install the package as usual via Composer:

```bash
composer require sergix44/nutgram
```

And you ready to go!

## Configuration

The framework can work out-of-the-box without much configuration, the only mandatory parameter is (obviously) the
Telegram API token:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram('you telegram token here');
```

The full option list you can specify as second parameter, is:

```php
use SergiX44\Nutgram\Nutgram;

$config = [
    'api_url' => 'https://api.telegram.org', // default, useful to switch to a local api
    'timeout' => 10, // default in seconds, when contacting the Telegram API
    'cache' => <class|instance>, // instance or class that implements CacheInterface, the default is the ArrayCache
];

$bot = new Nutgram('you telegram token here', $config);
```