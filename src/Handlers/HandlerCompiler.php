<?php

namespace SergiX44\Nutgram\Handlers;

trait HandlerCompiler
{
    private const NAME = 'handlers.cache';

    private bool $compiledLoaded = false;

    public function compiledHandlersAreLoaded(): bool
    {
        return $this->compiledLoaded;
    }

    public function generateCompiledHandlers(): bool
    {
        return $this->globalCache->set(self::NAME, serialize($this->handlers));
    }

    public function clearCompiledHandlers(): bool
    {
        return $this->globalCache->delete(self::NAME);
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
        return $this->compiledLoaded = true;
    }
}
