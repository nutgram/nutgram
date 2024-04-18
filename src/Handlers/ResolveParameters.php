<?php

namespace SergiX44\Nutgram\Handlers;

trait ResolveParameters
{
    protected array $parametersResolvers = [];

    public function bindParameter(string $name, callable $resolver): void
    {

        $this->parametersResolvers[$name] = $resolver;
    }

    public function resolveParameters(array $parameters): array
    {
        foreach ($parameters as $name => $value) {
            if (isset($this->parametersResolvers[$name])) {
                $parameters[$name] = $this->parametersResolvers[$name]($value);
            }
        }

        return $parameters;
    }
}
