<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use ArrayAccess;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Testing\Assert;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Assert as PHPUnit;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * @mixin FakeNutgram
 */
trait Asserts
{
    private int $sequenceIndex = 0;

    /**
     * Asserts custom conditions on the request and response.
     * @param callable(Request):bool $closure
     * @param int|null $index
     * @param string $message
     * @return static
     */
    public function assertRaw(callable $closure, ?int $index = null, string $message = ''): static
    {
        $index = $index ?? $this->sequenceIndex;
        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        /** @var Response $response */
        [$request, $response] = array_values($reqRes);

        PHPUnit::assertTrue($closure($request, new ResponseData($response)), $message);

        return $this;
    }

    /**
     * Asserts that a method was called.
     * @param string $method
     * @param int $times
     * @return static
     */
    public function assertCalled(string $method, int $times = 1): static
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
     * Asserts that a reply was sent.
     * @param string|string[] $method
     * @param array|null $expected
     * @param int|null $index
     * @return static
     */
    public function assertReply(string|array $method, ?array $expected = null, ?int $index = null): static
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
     * Asserts that the reply message is equal to the expected message.
     * @param array $expected
     * @param int|null $index
     * @param string|null $forceMethod
     * @return static
     */
    public function assertReplyMessage(array $expected, ?int $index = null, ?string $forceMethod = null): static
    {
        $index = $index ?? $this->sequenceIndex;
        return $this->assertReply($forceMethod ?? $this->methodsReturnTypes[Message::class] ?? [], $expected, $index);
    }

    /**
     * Asserts that the reply message text is equal to the expected text.
     * @param string $expected
     * @param int|null $index
     * @return static
     */
    public function assertReplyText(string $expected, ?int $index = null): static
    {
        $index = $index ?? $this->sequenceIndex;
        return $this->assertReplyMessage(['text' => $expected], $index);
    }

    /**
     * Asserts that a conversation is active.
     * @param int|null $userId
     * @param int|null $chatId
     * @param int|null $threadId
     * @return static
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertActiveConversation(?int $userId = null, ?int $chatId = null, ?int $threadId = null): static
    {
        [$userId, $chatId] = $this->checkUserChatIds($userId, $chatId);

        PHPUnit::assertNotNull($this->currentConversation($userId, $chatId, $threadId), 'No active conversation found');

        return $this;
    }

    /**
     * Asserts that no conversation is active.
     * @param int|null $userId
     * @param int|null $chatId
     * @param int|null $threadId
     * @return static
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function assertNoConversation(?int $userId = null, ?int $chatId = null, ?int $threadId = null): static
    {
        [$userId, $chatId] = $this->checkUserChatIds($userId, $chatId);

        PHPUnit::assertNull($this->currentConversation($userId, $chatId, $threadId), 'Found an active conversation');

        return $this;
    }

    /**
     * Asserts that no reply was sent.
     * @return static
     */
    public function assertNoReply(): static
    {
        PHPUnit::assertEmpty($this->testingHistory, 'A reply was sent');

        return $this;
    }

    /**
     * Asserts that the sequence of calls is correct.
     * @param callable ...$callbacks
     * @return static
     */
    public function assertSequence(callable ...$callbacks): static
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
        Assert::assertArraySubset($subset, $array, $checkForIdentity, $msg);
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
