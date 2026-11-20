<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\RunningMode;

use Closure;
use JsonException;
use JsonMapper_Exception;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Webhook implements RunningMode, RespondsToWebhook
{
    protected bool $safeMode = false;
    protected Closure $resolveSecretToken;
    protected ?string $secretToken = null;

    /**
     * @param string|null $secretToken Secret token to verify incoming requests.
     * @param Closure|null $getToken A closure that returns the secret token. If not provided, it will look for the token in the `HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN` header.
     */
    public function __construct(?string $secretToken = null, ?Closure $getToken = null)
    {
        $this->secretToken = $secretToken;
        $this->resolveSecretToken = $getToken ?? static fn (): string => $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '';
    }

    /**
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function processUpdates(Nutgram $bot): void
    {
        $input = $this->input();

        if ($input === null || ($this->safeMode && ($this->resolveSecretToken)() !== $this->secretToken)) {
            return;
        }

        $update = null;
        try {
            /** @var Update $update */
            $update = new Hydrator($bot->getContainer())
                ->hydrate(Update::class, json_decode($input, flags: JSON_THROW_ON_ERROR));

            $bot->processUpdate($update);

            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->debug(sprintf('Update processed: %s%s%s', $update->getType()?->value ?? '', PHP_EOL, $input));
        } catch (Throwable $e) {
            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->error(sprintf('Update failed: %s%s%s', $update?->getType()?->value ?? '', PHP_EOL, $input), ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * The response is flushed right away with fastcgi_finish_request(), so PHP-FPM is required.
     */
    public function canRespond(): bool
    {
        return function_exists('fastcgi_finish_request') && !headers_sent();
    }

    /**
     * @param array<array-key, mixed> $parameters
     * @throws JsonException
     */
    public function respond(string $method, array $parameters): void
    {
        header('Content-Type: application/json', response_code: 200);
        echo json_encode(['method' => $method, ...$parameters], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        fastcgi_finish_request();
    }

    public function isSafeMode(): bool
    {
        return $this->safeMode;
    }

    public function setSafeMode(bool $safeMode): self
    {
        $this->safeMode = $safeMode;
        return $this;
    }

    protected function input(): ?string
    {
        return file_get_contents('php://input') ?: null;
    }
}
