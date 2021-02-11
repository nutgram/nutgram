<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait InteractsWithUpdates
 * @package SergiX44\Nutgram\Handlers
 * @mixin ResolveHandlers
 */
trait InteractsWithUpdates
{
    /**
     * @return int|null
     */
    protected function getActualChatId(): ?int
    {
        if ($this->update === null) {
            return null;
        }

        $type = $this->update->getType();

        if ($type === UpdateTypes::MESSAGE) {
            return $this->update->message->chat->id;
        }

        if ($type === UpdateTypes::CALLBACK_QUERY) {
            return $this->update->callback_query->message->chat->id;
        }


        return null;
    }
}
