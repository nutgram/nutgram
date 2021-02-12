<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Conversation\Conversation;
use SergiX44\Nutgram\Conversation\ConversationRepository;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait ResolveHandlers
 * @package SergiX44\Nutgram\Handlers
 */
abstract class ResolveHandlers extends CollectHandlers
{

    /**
     * @var ConversationRepository
     */
    protected ConversationRepository $conversation;

    /**
     * @var Update
     */
    protected Update $update;

    protected function resolveHandlers()
    {
        $resolvedHandlers = [];
        $this->handlersByType(Update::class, $resolvedHandlers);
        $this->handlersByType(Message::class, $resolvedHandlers);

        // TODO
    }

    protected function continueConversation(Conversation $conversation)
    {
    }

    protected function handlersByType(string $type, array &$handlers): void
    {
        $typedHandlers = $this->handlers[$type] ?? null;
        if ($typedHandlers !== null) {
            $handlers = array_merge_recursive($handlers, $typedHandlers);
        }
    }
}
