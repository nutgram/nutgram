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
    /**
     * @var array|string[]
     */
    public const TELEGRAM_IPV4_RANGES = [
        '149.154.160.0' => '149.154.175.255', // literally 149.154.160.0/20
        '91.108.4.0' => '91.108.7.255',    // literally 91.108.4.0/22
    ];


    /**
     * In safe mode If received request from a ip other than telegram ips, the robot will not respond
     * @var bool
     */
    protected bool $safeMode = false;

    /**
     * @var Closure
     */
    protected Closure $resolveIp;

    /**
     * @param Closure|null $resolveIp
     */
    public function __construct(?Closure $resolveIp = null)
    {
        $this->resolveIp = $resolveIp ?? static fn (): string => $_SERVER['REMOTE_ADDR'];
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

        if ($input === null || ($this->safeMode && !$this->isSafeIpv4())) {
            return;
        }

        /** @var Update $update */
        $update = $bot->getContainer()
            ->get(Hydrator::class)
            ->hydrate(json_decode($input, true, flags: JSON_THROW_ON_ERROR), Update::class);

        try {
            $bot->processUpdate($update);

            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->debug(sprintf('Update processed: %s%s%s', $update->getType()?->value, PHP_EOL, $input));
        } catch (Throwable) {
            $bot->getContainer()
                ->get(LoggerInterface::class)
                ->error(sprintf('Update failed: %s%s%s', $update->getType()?->value, PHP_EOL, $input));
        }
    }


    /**
     * @return bool
     */
    public function isSafeIpv4(): bool
    {
        $ip = ip2long(call_user_func($this->resolveIp));

        if ($ip === false) {
            return false;
        }

        foreach (self::TELEGRAM_IPV4_RANGES as $lower => $upper) {
            // Make sure the IPv4 is valid.
            if ($ip >= ip2long($lower) && $ip <= ip2long($upper)) {
                return true;
            }
        }
        return false;
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
     * @param Closure $resolveIp
     * @return Webhook
     */
    public function requestIpFrom(Closure $resolveIp): Webhook
    {
        $this->resolveIp = $resolveIp;
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
