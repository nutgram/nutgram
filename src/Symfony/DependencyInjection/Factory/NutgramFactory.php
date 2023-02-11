<?php

namespace SergiX44\Nutgram\Symfony\DependencyInjection\Factory;

use Illuminate\Contracts\Cache\Repository as Cache;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Nutgram;

class NutgramFactory
{
    public function createNutgram(string $token, array $config, CacheInterface $cache, LoggerInterface $logger)
    {
        $config = array_merge([
            'cache' => $cache,
            'logger' => $logger,
        ], $config['config'] ?? []);

        return new Nutgram($token, $config);
    }
}
