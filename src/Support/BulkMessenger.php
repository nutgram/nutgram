<?php

namespace SergiX44\Nutgram\Support;

use RuntimeException;
use SergiX44\Nutgram\Nutgram;

class BulkMessenger
{
    public Nutgram $bot;
    private array $parameters = [];
    private string $method = 'sendMessage';
    protected int $seconds = 2;
    private array $chats = [];

    /**
     * @param  Nutgram  $bot
     */
    public function __construct(Nutgram $bot)
    {
        if
        (!extension_loaded('pcntl'))
        {
            throw new RuntimeException('The pcntl extension is required.');
        }

        if (PHP_SAPI !== 'cli') {
            throw new RuntimeException('You can use the bulk messenger only via CLI.');
        }

        $this->bot = $bot;
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return $this
     */
    public function setPayload(string $method, array $parameters): static
    {
        $this->method = $method;
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param  array  $chats
     * @return $this
     */
    public function setChats(array $chats): static
    {
        $this->chats = $chats;
        return $this;
    }

    /**
     * @param  int  $seconds
     * @return $this
     */
    public function setInterval(int $seconds): static
    {
        $this->seconds = $seconds;
        return $this;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        pcntl_async_signals(true);
        pcntl_signal(SIGALRM, $this);

        $this();
    }

    /**
     * @return void
     */
    public function __invoke(): void
    {
        $chatId = array_shift($this->chats);

        if ($chatId === null) {
            return;
        }

        $parameters = array_merge($this->parameters, ['chat_id' => $chatId]);

        $this->bot->{$this->method}(...$parameters);
        pcntl_alarm($this->seconds);
    }
}
