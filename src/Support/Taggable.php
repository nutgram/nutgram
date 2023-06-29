<?php

namespace SergiX44\Nutgram\Support;

trait Taggable
{
    protected array $tags = [];

    /**
     * Set a meta value
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function tag(string $key, mixed $value = null): self
    {
        $this->tags[$key] = $value;
        return $this;
    }

    /**
     * Set multiple meta values
     * @param array<string, mixed> $values
     * @return $this
     */
    public function tags(array $values): self
    {
        $this->tags = $values;
        return $this;
    }

    /**
     * Get a meta value
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getTag(string $key, mixed $default = null): mixed
    {
        return $this->tags[$key] ?? $default;
    }

    /**
     * Get all meta values
     * @return array<string, mixed>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Check if a meta value exists
     * @param string $key
     * @return bool
     */
    public function hasTag(string $key): bool
    {
        return array_key_exists($key, $this->getTags());
    }

    /**
     * Remove a meta value
     * @param string $key
     * @return $this
     */
    public function removeTag(string $key): self
    {
        unset($this->tags[$key]);
        return $this;
    }

    /**
     * Remove all meta values
     * @return $this
     */
    public function clearTags(): self
    {
        $this->tags = [];
        return $this;
    }
}
