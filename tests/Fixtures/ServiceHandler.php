<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Nutgram;

class ServiceHandler
{
    public function __construct(public MyService $service)
    {
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage($this->service->getValue());
    }
}
