<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class MultiTypeMultiClosure extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->sendMessage('start!');

        $this
            ->next('foo', fn (Nutgram $bot) => $bot->message()->text === 'foo')
            ->next('bar', fn (Nutgram $bot) => $bot->message()->text === 'bar');
    }

    public function foo(Nutgram $bot)
    {
        $bot->sendMessage('foo!');

        $this->end();
    }

    public function bar(Nutgram $bot)
    {
        $bot->sendMessage('bar!');

        $this->end();
    }
}
