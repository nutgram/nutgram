<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

class ConversationWithConstructor extends Conversation
{
    public function __construct(private CustomService $service)
    {
    }

    public function start(Nutgram $bot)
    {
        expect($this->service)->toBeInstanceOf(CustomService::class);
        $bot->set('test', 1);
        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot)
    {
        expect($this->service)->toBeInstanceOf(CustomService::class);
        $bot->set('test', 2);
        $this->end();
    }
}
