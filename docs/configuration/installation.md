---
sort: 1
---

# Installation

## Composer
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

In addition, it's possible to specify a list of options as second argument, like that:

```php
use SergiX44\Nutgram\Nutgram;

$config = [
    'timeout' => 10, // default in seconds, when contacting the Telegram API
];

$bot = new Nutgram('you telegram token here', $config);
```

Here a list of all the options you can specify:

### `api_url`
- **type:** string
- **default:** `'https://api.telegram.org'`
- Useful if you need to change to a local API server.

### `timeout`
- **type:** integer
- **default:** `10`
- In seconds, define the timeout when sending requests to the Telegram API.

### `cache`
- **type:** string or instance
- **default:** `ArrayCache`
- The object used to store conversation and data, must implements the PSR-16 `CacheInterface`.

### `client`
- **type:** array
- **default:** `[]`
- An array of options for the underlying [Guzzle HTTP client](https://docs.guzzlephp.org/en/stable/quickstart.html). Checkout the Guzzle documentation for further informations.

### `polling`
- **type:** array
- **default:** `['timeout' => 10, 'limit' => 100]`
- Contains all the options that used when requesting updates to Telegram via the `getUpdates`, it's possible to specify also
the field `allowed_updates` if you want.