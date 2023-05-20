<?php

namespace SergiX44\Nutgram\Handlers;

use Closure;
use InvalidArgumentException;
use Laravel\SerializableClosure\SerializableClosure;
use RuntimeException;

trait HandlerCompiler
{
    protected const FILENAME = 'handlers.cache';

    protected bool $loadedFromCache = false;

    protected function loadCompiledHandlers(string $path): void
    {
        $content = file_get_contents(sprintf("%s%s%s", $path, PHP_EOL, self::FILENAME));

        if ($content === false) {
            throw new InvalidArgumentException('Cannot load handlers cache file');
        }

        $data = unserialize($content);
        if (is_array($data)) {
            $this->handlers = $data;
            $this->loadedFromCache = true;
        } else {
            throw new RuntimeException('Cannot deserialize handlers cache file');
        }
    }

    protected function generateCompiledHandlers(string $path, array $handlers): false|int
    {
        array_walk_recursive($handlers, function (&$handler) {
            if ($handler instanceof Closure) {
                $handler = new SerializableClosure($handler);
            }
        });

        return file_put_contents(
            sprintf("%s%s%s", $path, PHP_EOL, self::FILENAME),
            serialize($handlers)
        );
    }
}
