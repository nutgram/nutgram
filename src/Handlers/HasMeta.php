<?php

namespace SergiX44\Nutgram\Handlers;

trait HasMeta
{
    protected array $metas = [];

    /**
     * Set a meta value
     * @param string $key
     * @param mixed $value
     * @return Handler
     */
    public function setMeta(string $key, mixed $value): self
    {
        $this->metas[$key] = $value;
        return $this;
    }

    /**
     * Set multiple meta values
     * @param array<string, mixed> $values
     * @return Handler
     */
    public function setMetas(array $values): self
    {
        $this->metas = $values;
        return $this;
    }

    /**
     * Get a meta value
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getMeta(string $key, mixed $default = null): mixed
    {
        return $this->getMetas()[$key] ?? $default;
    }

    /**
     * Get all meta values
     * @return array<string, mixed>
     */
    public function getMetas(): array
    {
        return $this->metas;
    }

    /**
     * Check if a meta value exists
     * @param string $key
     * @return bool
     */
    public function hasMeta(string $key): bool
    {
        return isset($this->getMetas()[$key]);
    }

    /**
     * Remove a meta value
     * @param string $key
     * @return Handler
     */
    public function removeMeta(string $key): self
    {
        unset($this->metas[$key]);
        return $this;
    }

    /**
     * Remove all meta values
     * @return Handler
     */
    public function clearMetas(): self
    {
        $this->metas = [];
        return $this;
    }
}
