<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Conversation;
use SergiX44\Nutgram\Proxies\UpdateProxy;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait ResolveHandlers
 * @package SergiX44\Nutgram\Handlers
 */
abstract class ResolveHandlers extends CollectHandlers
{
    use UpdateProxy;

    /**
     * @var ConversationCache
     */
    protected ConversationCache $conversationCache;

    /**
     * @var GlobalCache
     */
    protected GlobalCache $globalCache;

    /**
     * @var UserCache
     */
    protected UserCache $userCache;

    /**
     * @var Update|null
     */
    protected ?Update $update = null;

    /**
     * @return array
     */
    protected function resolveHandlers(): array
    {
        $resolvedHandlers = [];
        $this->filterHandlersBy($resolvedHandlers, Update::class);
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::MESSAGE) {
            if ($this->update?->message?->isCommand()) {
                $text = $this->update?->message?->getCommand().' '.$this->update?->message?->getArgs();
            } else {
                $text = $this->update->message?->text;
            }
            $this->filterHandlersBy($resolvedHandlers, $updateType, $text);
            if (empty($resolvedHandlers)) {
                $this->filterHandlersBy($resolvedHandlers, $updateType);
            }
        } elseif ($updateType === UpdateTypes::CALLBACK_QUERY) {
            $data = $this->update->callback_query?->data;
            $this->filterHandlersBy($resolvedHandlers, $updateType, $data);
            if (empty($resolvedHandlers)) {
                $this->filterHandlersBy($resolvedHandlers, $updateType);
            }
        } else {
            $this->filterHandlersBy($resolvedHandlers, $updateType);
        }

        return $resolvedHandlers;
    }

    /**
     * @param  array  $handlers
     * @param  string  $type
     * @param  null  $value
     */
    protected function filterHandlersBy(array &$handlers, string $type, $value = null): void
    {
        /*** @var Handler $handler */
        foreach ($this->handlers[$type] ?? [] as $handler) {
            if (
                ($value !== null && $handler->getPattern() === $value) ||
                ($value === null && $handler->getPattern() === null) ||
                ($value !== null && $handler->matching($value))
            ) {
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
        $resolvedHandlers = [];

        if (!$conversation->skipHandlers()) {
            $handlers = $this->resolveHandlers();

            /** @var Handler $handler */
            foreach ($handlers as $handler) {
                // if we found at least one specific handler,
                // we should escape the conversation
                if ($handler->getPattern() !== null) {
                    return $handlers;
                }
            }
        }

        $handler = new Handler($conversation);

        if (!$conversation->skipMiddlewares()) {
            $this->applyGlobalMiddlewaresTo($handler);
        }

        $resolvedHandlers[] = $handler;

        return $resolvedHandlers;
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
