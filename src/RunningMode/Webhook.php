<?php


namespace SergiX44\Nutgram\RunningMode;

use Closure;
use JsonMapper_Exception;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Webhook implements RunningMode
{
    protected bool $safeMode = false;

    protected Closure $resolveSecretToken;
    protected ?string $secretToken = null;

    /**
     * @param Closure|null $getToken
     * @param string|null $secretToken
     */
    public function __construct(?Closure $getToken = null, ?string $secretToken = null)
    {
        $this->resolveSecretToken = $getToken ?? static fn (): string => $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'];
        $this->secretToken = $secretToken;
    }


    /**
     * @param Nutgram $bot
     * @throws JsonMapper_Exception
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
            $update = $bot->getContainer()
                ->get(Hydrator::class)
                ->hydrate(json_decode($input, true, flags: JSON_THROW_ON_ERROR), Update::class);

            $bot->processUpdate($update);

            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->debug(sprintf('Update processed: %s%s%s', $update?->getType()?->value, PHP_EOL, $input));
        } catch (Throwable $e) {
            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->error(sprintf('Update failed: %s%s%s', $update?->getType()?->value, PHP_EOL, $input), ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * @return bool
     */
    public function isSafeMode(): bool
    {
        return $this->safeMode;
    }

    /**
     * @param bool $safeMode
     * @return self
     */
    public function setSafeMode(bool $safeMode): self
    {
        $this->safeMode = $safeMode;
        return $this;
    }

    /**
     * @return string|null
     */
    protected function input(): ?string
    {
        return file_get_contents('php://input') ?: null;
    }
}
