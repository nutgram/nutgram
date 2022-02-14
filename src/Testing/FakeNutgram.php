<?php

namespace SergiX44\Nutgram\Testing;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use function PHPUnit\Framework\assertEquals;

/**
 * @method assertSendMessageCalled
 */
class FakeNutgram extends Nutgram
{
    /**
     * @var MockHandler
     */
    protected MockHandler $mockHandler;

    /**
     * @var array
     */
    protected array $testingHistory = [];

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return FakeNutgram
     */
    public static function instance(mixed $update = null, array $responses = []): self
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        $bot = new self(__CLASS__, [
            'client' => ['handler' => $handlerStack],
            'api_url' => '',
        ]);

        $bot->setRunningMode(new Fake($update));
        $bot->setupHistoryContainer($handlerStack);
        $bot->setMockHandler($mock);

        return $bot;
    }

    /**
     * @param  mixed|null  $update
     * @return FakeNutgram
     */
    public function receivesRaw(mixed $update = null): self
    {
        $update = json_decode(json_encode($update));
        $this->setRunningMode(new Fake($update));
        $this->run();
        return $this;
    }

    public function receives(string $text): self
    {
        return $this->receivesRaw([
            'update_id' => 1,
            'message' => [
                'message_id' => 1,
                'from' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'username' => 'test_user',
                ],
                'chat' => [
                    'id' => 1,
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'username' => 'test_user',
                    'type' => 'private',
                ],
                'date' => 1,
                'text' => $text,
            ],
        ]);
    }

    /**
     * @param  mixed  $body
     * @param  int  $status
     * @param  array  $headers
     * @return FakeNutgram
     */
    public function withResponse(
        mixed $body = ['ok' => false, 'result' => null],
        int $status = 200,
        array $headers = [],
    ): self {
        $this->mockHandler->append(new Response($status, $headers, is_string($body) ? $body : json_encode($body, JSON_THROW_ON_ERROR)));
        return $this;
    }

    /**
     * @param  HandlerStack  $handlerStack
     */
    protected function setupHistoryContainer(HandlerStack $handlerStack): void
    {
        $history = Middleware::history($this->testingHistory);
        $handlerStack->push($history);
    }

    /**
     * @return array
     */
    public function getRequestHistory(): array
    {
        return $this->testingHistory;
    }

    /**
     * @param  MockHandler  $mockHandler
     * @return FakeNutgram
     */
    public function setMockHandler(MockHandler $mockHandler): static
    {
        $this->mockHandler = $mockHandler;
        return $this;
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return void
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        $lowerName = strtolower($name);

        // begin assertion
        match (str_starts_with($lowerName, 'assert')) {
            str_ends_with($lowerName, 'called') => $this->assertApiMethodCalled($this->extractName($name, 'called'), $arguments),
            default => throw new Exception('Invalid assertion')
        };
    }

    /**
     * @param  string  $name
     * @param  string  $string
     * @return string
     */
    private function extractName(string $name, string $string): string
    {
        return lcfirst(str_ireplace(['assert', $string], '', $name));
    }

    /**
     * @param $method
     * @param $arguments
     * @return void
     */
    private function assertApiMethodCalled($method, $arguments)
    {
        dd($method);
    }

    /**
     * @template T
     * @param  int  $index
     * @param  class-string<T>|null  $type
     * @return T|array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     * @throws \SergiX44\Nutgram\Telegram\Exceptions\TelegramException
     */
    public function getHistoryItemResponse(int $index = 0, string $type = null): mixed
    {
        $response = $this->getRequestHistory()[0]['response'];

        if ($type === null) {
            return json_decode((string)$response->getBody(), true);
        }

        return $this->mapResponse($response, $type);
    }

    public function sendMessage(string $text, ?array $opt = []): ?Message
    {
        $this->mockHandler->append(new Response(200, [], json_encode([
            'ok' => true,
            'result' =>
                [
                    'message_id' => 1,
                    'from' =>
                        [
                            'id' => 1,
                            'is_bot' => false,
                            'first_name' => 'First',
                            'last_name' => 'Last',
                            'username' => 'username',
                            'language_code' => 'en-US',
                        ],
                    'chat' =>
                        [
                            'id' => 1,
                            'first_name' => 'First',
                            'last_name' => 'Last',
                            'username' => 'username',
                            'type' => 'private',
                        ],
                    'date' => 1,
                    'text' => $text,
                ],
        ], JSON_THROW_ON_ERROR)));

        return parent::sendMessage($text, $opt);
    }

    protected int $historyIndex = 0;

    public function assertRaw(string $text): self
    {
        $response = $this->getRequestHistory()[$this->historyIndex]['response'];
        $response = (string)$response->getBody();

        assertEquals($text, $response);

        $this->historyIndex++;
        return $this;
    }

    public function assertReply(string $text): self
    {
        $response = $this->getRequestHistory()[$this->historyIndex]['response'];
        $response = (string)$response->getBody();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        assertEquals($text, $response['result']['text']);

        $this->historyIndex++;
        return $this;
    }
}
