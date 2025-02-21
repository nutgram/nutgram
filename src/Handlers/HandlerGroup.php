<?php

namespace SergiX44\Nutgram\Handlers;

use Closure;
use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Middleware\RateLimit;
use SergiX44\Nutgram\Support\Constraints;
use SergiX44\Nutgram\Support\Disable;
use SergiX44\Nutgram\Support\Taggable;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;

class HandlerGroup
{
    use Taggable, Macroable, Disable, Constraints;

    protected array $middlewares = [];

    protected array $scopes = [];

    protected ?RateLimit $rateLimit = null;

    public function __construct(public Closure $groupCallable)
    {
    }

    public function middleware(string|array|callable|object $callable): self
    {
        array_unshift($this->middlewares, $callable);
        return $this;
    }

    public function scope(BotCommandScope|array $scope): self
    {
        if (!is_array($scope)) {
            $scope = [$scope];
        }

        $this->scopes = array_merge($this->scopes, $scope);
        return $this;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getHash(): string
    {
        $data = [
            'disabled' => $this->disabled,
            'constraints' => $this->constraints,
            'tags' => $this->tags,
        ];

        return (string)crc32(serialize($data));
    }

    public function throttle(int $maxAttempts, int $decaySeconds = 60, ?string $key = null): self
    {
        $this->rateLimit = new RateLimit(
            maxAttempts: $maxAttempts,
            decaySeconds: $decaySeconds,
            key: $key ?? $this->getHash(),
        );

        return $this;
    }

    public function getRateLimit(): ?RateLimit
    {
        return $this->rateLimit;
    }
}
