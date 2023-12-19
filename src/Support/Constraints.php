<?php

namespace SergiX44\Nutgram\Support;

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
