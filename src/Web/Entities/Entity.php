<?php

namespace SergiX44\Nutgram\Web\Entities;

use DateTime;

abstract readonly class Entity
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $this->castValue($key, $value);
            }
        }
    }

    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    protected function cast(): array
    {
        return [];
    }

    private function castValue(string $key, mixed $value): mixed
    {
        if (!array_key_exists($key, $this->cast())) {
            return $value;
        }

        if ($value === null) {
            return null;
        }

        if (is_subclass_of($this->cast()[$key], __CLASS__)) {
            return $this->cast()[$key]::fromArray(json_decode($value, true));
        }

        return match ($this->cast()[$key]) {
            'int' => (int)$value,
            'float' => (float)$value,
            'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'datetime' => DateTime::createFromFormat('U', $value),
            default => $value,
        };
    }
}
