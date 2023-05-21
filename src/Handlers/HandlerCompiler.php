<?php

namespace SergiX44\Nutgram\Handlers;

trait HandlerCompiler
{
    protected const NAME = 'handlers.cache';

    protected bool $fromCompiled = false;

    /**
     * @return bool
     */
    public function loadedFromCompiled(): bool
    {
        return $this->fromCompiled;
    }

    protected function loadCompiledHandlers(): bool
    {
        $content = $this->globalCache->get(self::NAME);

        if ($content === false) {
            return false;
        }

        $data = unserialize($content);

        if (!is_array($data)) {
            return false;
        }

        $this->handlers = $data;
        $this->fromCompiled = true;
        return true;
    }

    protected function generateCompiledHandlers(array $handlers): false|int
    {
        return $this->globalCache->set(self::NAME, serialize($handlers));
    }
}
