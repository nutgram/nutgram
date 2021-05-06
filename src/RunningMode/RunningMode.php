<?php


namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;

interface RunningMode
{
    public function processUpdates(Nutgram $bot): void;
}
