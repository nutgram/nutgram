---
sort: 2
---

# Cache

Nutgram accepts as a cache system any adapter that implements the PSR-16 `CacheInterface` interface.

By default, it uses the internal `ArrayCache` class, which is non-persistent, useful only when the bot is running in
polling mode.

```warning
Without configuring a cache adapter accordingly, feature like global or per-user object storage and conversations may not work!
```

## Configuration

To specify a different cache adapter, you need to pass the instance at the bot instantiation. The following example, we
are using the [Symfony Cache](https://symfony.com/doc/current/components/cache.html), since they are providing multiple
adapters out-of-the-box:

```php
use SergiX44\Nutgram\Nutgram;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

$psr6Cache = new FilesystemAdapter();
$psr16Cache = new Psr16Cache($psr6Cache);

$bot = new Nutgram('TOKEN', [
    'cache' => $psr16Cache
]);
```

```note
If you are using Laravel, you can skip this section, since the service provider automatically inject the Laravel cache repository for you.

[Check out the Laravel integration page](laravel.md)
```