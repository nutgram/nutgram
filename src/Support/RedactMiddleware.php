<?php

namespace SergiX44\Nutgram\Support;

use GuzzleHttp\Promise\RejectedPromise;
use ReflectionProperty;
use SensitiveParameter;
use Throwable;

final readonly class RedactMiddleware
{
    public function __construct(#[SensitiveParameter] private string $token)
    {
    }

    public function __invoke(callable $handler): callable
    {
        return function ($request, array $options) use ($handler) {
            return $handler($request, $options)->otherwise(function ($reason) {
                if ($reason instanceof Throwable) {
                    $exception = $reason;

                    do {
                        $property = new ReflectionProperty($exception, 'message');

                        $property->setValue(
                            $exception,
                            str_replace($this->token, str_repeat('*', 5), $exception->getMessage())
                        );
                    } while ($exception = $exception->getPrevious());
                }

                return new RejectedPromise($reason);
            });
        };
    }
}
