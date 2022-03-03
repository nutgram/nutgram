<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;
use Illuminate\Testing\Assert as LaraUnit;
use JsonException;
use PHPUnit\Framework\Assert as PHPUnit;
use SergiX44\Nutgram\Telegram\Types\BaseType;

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
        array_walk_recursive($expected, static function (&$leaf) {
            if ($leaf instanceof BaseType) {
                $leaf = $leaf->toArray();
            }
        });

        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        try {
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
     * @return self
     */
    public function assertReplyText(string $expected, int $index = 0): self
    {
        $this->assertReply(['text' => $expected], $index);

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
