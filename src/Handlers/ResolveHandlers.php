<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Conversation\Conversation;
use SergiX44\Nutgram\Conversation\ConversationRepository;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait ResolveHandlers
 * @package SergiX44\Nutgram\Handlers
 */
abstract class ResolveHandlers extends CollectHandlers
{
    use ResolveIds;

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
        $resolvedHandlers = [];
        $this->getHandlersByType(Update::class, $resolvedHandlers);
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::MESSAGE) {
            $this->getHandlersByType(Message::class, $resolvedHandlers);
            $text = $this->update->message->text;
            if ($text !== null) {
                $this->filterHandlersBy(Message::class, $text, $resolvedHandlers);
            }
        } elseif ($updateType === UpdateTypes::CALLBACK_QUERY) {
            $this->getHandlersByType(CallbackQuery::class, $resolvedHandlers);
            $data = $this->update->callback_query->data;
            if ($data !== null) {
                $this->filterHandlersBy(CallbackQuery::class, $data, $resolvedHandlers);
            }
        } else {
            $this->getHandlersByType($updateType, $resolvedHandlers);
        }

        return $resolvedHandlers;
    }

    /**
     * @param  string  $type
     * @param  array  $handlers
     * @return void
     */
    protected function getHandlersByType(string $type, array &$handlers): void
    {
        $typedHandlers = $this->handlers[$type] ?? null;
        if ($typedHandlers !== null) {
            $handlers = array_merge($handlers, $typedHandlers);
        }
    }

    /**
     * @param  string  $type
     * @param  string  $value
     * @param  array  $handlers
     */
    protected function filterHandlersBy(string $type, string $value, array &$handlers): void
    {
        /*** @var Handler $handler */
        foreach ($this->handlers[$type] ?? [] as $handler) {
            if ($handler->matching($value)) {
                $handlers[] = $handler;
            }
        }
    }

    /**
     * @param  Conversation  $conversation
     * @return array
     */
    protected function continueConversation(Conversation $conversation): array
    {
        $resolvedHandlers = $this->resolveHandlers();
        if (!$conversation->skipHandlers() && !empty($resolvedHandlers)) {
            return $resolvedHandlers;
        }

        $handler = new Handler($conversation);

        if (!$conversation->skipMiddlewares()) {
            $this->applyGlobalMiddlewaresTo($handler);
        }

        return [$handler];
    }

    /**
     * @param  Handler  $handler
     */
    protected function applyGlobalMiddlewaresTo(Handler $handler): void
    {
        foreach ($this->globalMiddlewares as $middleware) {
            $handler->middleware($middleware);
        }
    }

    protected function applyGlobalMiddlewares(): void
    {
        array_walk_recursive($this->handlers, function ($leaf) {
            if ($leaf instanceof Handler) {
                $this->applyGlobalMiddlewaresTo($leaf);
            }
        });
    }
}
