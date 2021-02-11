<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait ResolveHandlers
 * @package SergiX44\Nutgram\Handlers
 */
abstract class ResolveHandlers extends CollectHandlers
{
    use InteractsWithUpdates;

    /**
     * @var Update
     */
    protected Update $update;

    /**
     * @param  Update  $update
     */
    public function processUpdate(Update $update)
    {
        $this->update = $update;
        $this->handlers[Message::class][0]($this);

    }
}
