<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support;

use RuntimeException;
use SergiX44\Nutgram\Nutgram;

class BulkMessenger
{
    public Nutgram $bot;
    private int $seconds = 2;
    private array $chats = [];
    private string $text = 'Hello!';
    private array $opt = [];

    /**
     * @var callable
     */
    private $callable;

    public function __construct(Nutgram $bot)
    {
        if (!$this->isCli()) {
            throw new RuntimeException('You can use the bulk messenger only via CLI.');
        }

        $this->bot = $bot;
        $this->callable = function (Nutgram $bot, int|string $chatId): void {
            $bot->sendMessage(...[...$this->opt, 'chat_id' => $chatId, 'text' => $this->text]);
        };
    }

    /**
     * @return $this
     */
    public function using(callable $action): static
    {
        $this->callable = $action;
        return $this;
    }

    /**
     * @return $this
     */
    public function setChats(array $chats): static
    {
        $this->chats = $chats;
        return $this;
    }

    /**
     * @return $this
     */
    public function setInterval(int $seconds): static
    {
        $this->seconds = $seconds;
        return $this;
    }

    /**
     * @return $this
     */
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return $this
     */
    public function setOpt(array $params): static
    {
        $this->opt = $params;
        return $this;
    }

    public function startAsync(): void
    {
        if (!$this->hasPcntl()) {
            throw new RuntimeException('The pcntl extension is required.');
        }

        pcntl_async_signals(true);
        pcntl_signal(SIGALRM, $this->handleAlarm(...));

        $this->handleAlarm();
    }

    public function handleAlarm(): void
    {
        $this();
        pcntl_alarm($this->seconds);
    }

    public function startSync(): void
    {
        while (!empty($this->chats)) {
            $this();
            sleep($this->seconds);
        }
    }

    public function __invoke(): void
    {
        $chatId = array_shift($this->chats);

        if ($chatId === null) {
            return;
        }

        ($this->callable)($this->bot, $chatId);
    }

    protected function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    protected function hasPcntl(): bool
    {
        return extension_loaded('pcntl');
    }
}
