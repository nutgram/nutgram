<?php

namespace SergiX44\Nutgram\Testing;

use SergiX44\Nutgram\Telegram\Types\Message\Message;

class SequenceAsserter
{
    public function __construct(
        protected FakeNutgram $bot,
        protected int $index,
    ) {
    }

    public function assertRaw(callable $closure): self
    {
        $this->bot->assertRaw($closure, $this->index);
        return $this;
    }

    public function assertReply(string|array $method, ?array $expected = null): self
    {
        $this->bot->assertReply($method, $expected, $this->index);
        return $this;
    }

    public function assertReplyMessage(array $expected, ?string $forceMethod = null): self
    {
        return $this->assertReply($forceMethod ?? $this->bot->getMethodsReturnTypes()[Message::class] ?? [], $expected);
    }

    public function assertReplyText(string $expected): self
    {
        return $this->assertReplyMessage(['text' => $expected]);
    }
}
