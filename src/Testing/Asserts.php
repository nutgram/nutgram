<?php

namespace SergiX44\Nutgram\Testing;

use ArrayAccess;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Assert as PHPUnit;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Testing\Constraints\ArraySubset;

/**
 * @mixin FakeNutgram
 */
trait Asserts
{
    private int $sequenceIndex = 0;

    /**
     * @param callable(Request):bool $closure
     * @param int|null $index
     * @return $this
     */
    public function assertRaw(callable $closure, ?int $index = null, string $message = ''): self
    {
        $index = $index ?? $this->sequenceIndex;
        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        PHPUnit::assertTrue($closure($request), $message);

        return $this;
    }

    /**
     * @param string $method
     * @param int $times
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
     * @param string|string[] $method
     * @param array|null $expected
     * @param int|null $index
     * @return $this
     */
    public function assertReply(string|array $method, ?array $expected = null, ?int $index = null): self
    {
        $index = $index ?? $this->sequenceIndex;
        $method = !is_array($method) ? [$method] : $method;

        $reqRes = $this->testingHistory[$index];

        if ($reqRes === null) {
            PHPUnit::fail('No request found');
        }

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        PHPUnit::assertContains($request->getUri()->getPath(), $method, 'Method name not found');

        if ($expected !== null) {
            try {
                $expected = json_decode(json_encode($expected), true, 512, JSON_THROW_ON_ERROR);
                $actual = FakeNutgram::getActualData($request, $expected);
            } catch (JsonException) {
                $actual = [];
            }

            $this->assertArraySubset($expected, $actual, msg: 'Sub array not found in the request body');
        }

        return $this;
    }

    /**
     * @param array $expected
     * @param int|null $index
     * @param string|null $forceMethod
     * @return $this
     */
    public function assertReplyMessage(array $expected, ?int $index = null, ?string $forceMethod = null): self
    {
        $index = $index ?? $this->sequenceIndex;
        return $this->assertReply($forceMethod ?? $this->methodsReturnTypes[Message::class] ?? [], $expected, $index);
    }

    /**
     * @param string $expected
     * @param int|null $index
     * @return $this
     */
    public function assertReplyText(string $expected, ?int $index = null): self
    {
        $index = $index ?? $this->sequenceIndex;
        return $this->assertReplyMessage(['text' => $expected], $index);
    }

    /**
     * @param int|null $userId
     * @param int|null $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertActiveConversation(?int $userId = null, ?int $chatId = null): self
    {
        [$userId, $chatId] = $this->checkUserChatIds($userId, $chatId);

        PHPUnit::assertNotNull($this->currentConversation($userId, $chatId), 'No active conversation found');

        return $this;
    }

    /**
     * @param int|null $userId
     * @param int|null $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertNoConversation(?int $userId = null, ?int $chatId = null): self
    {
        [$userId, $chatId] = $this->checkUserChatIds($userId, $chatId);

        PHPUnit::assertNull($this->currentConversation($userId, $chatId), 'Found an active conversation');

        return $this;
    }

    /**
     * @return $this
     */
    public function assertNoReply(): self
    {
        PHPUnit::assertEmpty($this->testingHistory, 'A reply was sent');

        return $this;
    }

    public function assertSequence(callable ...$callbacks): self
    {
        $closures = func_get_args();

        foreach ($closures as $index => $closure) {
            $this->sequenceIndex = $index;
            $closure($this);
        }

        $this->sequenceIndex = 0;

        return $this;
    }

    protected function assertArraySubset(
        ArrayAccess|array $subset,
        ArrayAccess|array $array,
        bool $checkForIdentity = false,
        string $msg = ''
    ): void {
        $constraint = new ArraySubset($subset, $checkForIdentity);
        PHPUnit::assertThat($array, $constraint, $msg);
    }

    /**
     * @param int|null $userId
     * @param int|null $chatId
     * @return array
     */
    private function checkUserChatIds(?int $userId, ?int $chatId): array
    {
        $userId = $this->storedUser?->id ?? $userId;
        $chatId = $this->storedChat?->id ?? $chatId;

        if ($userId === null || $chatId === null) {
            throw new InvalidArgumentException('You cannot do this assert without userId and chatId.');
        }
        return [$userId, $chatId];
    }
}
