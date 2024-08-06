<?php

namespace SergiX44\Nutgram\Support;

use BackedEnum;

trait Constraints
{
    protected array $constraints = [];

    public function where(array|string $parameter, ?string $constraint = null): self
    {
        if (!is_array($parameter)) {
            $constraints = [$parameter => $constraint];
        } else {
            $constraints = $parameter;
        }

        $this->constraints = [...$this->constraints, ...$constraints];

        return $this;
    }

    public function whereIn(string $parameter, array $values): self
    {
        $values = array_map(function (mixed $item) {
            if ($item instanceof BackedEnum) {
                $item = $item->value;
            }

            return (string)$item;
        }, $values);

        $this->constraints[$parameter] = implode('|', $values);

        return $this;
    }

    public function whereAlpha(string $parameter): self
    {
        $this->constraints[$parameter] = '[a-zA-Z]+';

        return $this;
    }

    public function whereNumber(string $parameter): self
    {
        $this->constraints[$parameter] = '[0-9]+';

        return $this;
    }

    public function whereAlphaNumeric(string $parameter): self
    {
        $this->constraints[$parameter] = '[a-zA-Z0-9]+';

        return $this;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
