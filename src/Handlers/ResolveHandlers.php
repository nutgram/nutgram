<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Conversation\Conversation;
use SergiX44\Nutgram\Conversation\ConversationRepository;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
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

    /**
     * @return array
     */
    protected function resolveHandlers(): array
    {
        $resolvedHandlers = $this->handlersByType(Update::class, []);
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::MESSAGE) {

        } elseif ($updateType === UpdateTypes::CALLBACK_QUERY) {

        } else {
            $resolvedHandlers = $this->handlersByType($updateType, $resolvedHandlers);
        }

        return $resolvedHandlers;
    }

    /**
     * @param  Conversation  $conversation
     * @return array
     */
    protected function continueConversation(Conversation $conversation): array
    {
    }

    /**
     * @param  string  $type
     * @param  array  $handlers
     * @return array
     */
    protected function handlersByType(string $type, array $handlers): array
    {
        $typedHandlers = $this->handlers[$type] ?? null;
        if ($typedHandlers !== null) {
            return array_merge_recursive($handlers, $typedHandlers);
        }

        return $handlers;
    }
}
