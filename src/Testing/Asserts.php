<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;
use Illuminate\Testing\Assert as LaraUnit;
use JsonException;
use PHPUnit\Framework\Assert as PHPUnit;

/**
 * @mixin FakeNutgram
 */
trait Asserts
{
    /**
     * @param  callable  $closure
     * @param  int  $index
     * @return self
     */
    public function assertRaw(callable $closure, int $index = 0): self
    {
        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        PHPUnit::assertTrue($closure($request));

        return $this;
    }

    /**
     * @param  string  $method
     * @param  int  $times
     * @return self
     */
    public function assertCalled(string $method, int $times = 1): self
    {
        $actual = 0;
        foreach ($this->testingHistory as $reqRes) {
            /** @var Request $request */
            [$request,] = array_values($reqRes);

            if ($request->getUri()->getPath() === $method) {
                $actual++;
            }
        }

        PHPUnit::assertEquals($times, $actual);

        return $this;
    }

    /**
     * @param  array  $expected
     * @param  int  $index
     * @return self
     */
    public function assertReply(array $expected, int $index = 0): self
    {
        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        try {
            $expected = json_decode(json_encode($expected), true);
            $actual = json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            $actual = [];
        }

        LaraUnit::assertArraySubset($expected, $actual);

        return $this;
    }

    /**
     * @param  string  $expected
     * @param  int  $index
     * @return $this
     */
    public function assertReplyText(string $expected, int $index = 0): self
    {
        $this->assertReply(['text' => $expected], $index);

        return $this;
    }

    /**
     * @param  int  $userId
     * @param  int  $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertActiveConversation(int $userId, int $chatId): self
    {
        PHPUnit::assertNotNull($this->getConversation($userId, $chatId));

        return $this;
    }

    /**
     * @param  int  $userId
     * @param  int  $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertNoConversation(int $userId, int $chatId): self
    {
        PHPUnit::assertNull($this->getConversation($userId, $chatId));

        return $this;
    }

    /**
     * @return self
     */
    public function assertNoReply(): self
    {
        PHPUnit::assertEmpty($this->testingHistory);

        return $this;
    }
}
