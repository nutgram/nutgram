<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;
use Illuminate\Testing\Assert as LaraUnit;
use InvalidArgumentException;
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
     * @return $this
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
     * @return $this
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

        PHPUnit::assertEquals($times, $actual, "The method '$method' was called $actual instead of $times");

        return $this;
    }

    /**
     * @param  array  $expected
     * @param  int  $index
     * @return $this
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

        LaraUnit::assertArraySubset($expected, $actual, msg: 'Sub array not found in the request body');

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
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return $this
     */
    public function assertActiveConversation(?int $userId = null, ?int $chatId = null): self
    {
        $userId = $this->storedUser?->id ?? $userId;
        $chatId = $this->storedChat?->id ?? $chatId;

        if ($userId === null || $chatId === null) {
            throw new InvalidArgumentException('You cannot do this assert without userId and chatId.');
        }

        PHPUnit::assertNotNull($this->getConversation($userId, $chatId), 'No active conversation found');

        return $this;
    }

    /**
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return $this
     */
    public function assertNoConversation(?int $userId = null, ?int $chatId = null): self
    {
        $userId = $this->storedUser?->id ?? $userId;
        $chatId = $this->storedChat?->id ?? $chatId;

        if ($userId === null || $chatId === null) {
            throw new InvalidArgumentException('You cannot do this assert without userId and chatId.');
        }

        PHPUnit::assertNull($this->getConversation($userId, $chatId), 'Found an active conversation');

        return $this;
    }

    /**
     * @return self
     */
    public function assertNoReply(): self
    {
        PHPUnit::assertEmpty($this->testingHistory, 'A reply was sent');

        return $this;
    }
}
