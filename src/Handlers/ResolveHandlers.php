<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Conversation;
use SergiX44\Nutgram\Proxies\UpdateProxy;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

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
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::MESSAGE) {
            $text = $this->update?->message?->getParsedCommand() ?? $this->update->message?->text;

            if ($text !== null) {
                $this->addHandlersBy($resolvedHandlers, $updateType, $this->update?->message?->getType(), $text);
            }

            if (count($resolvedHandlers) === 0) {
                $this->addHandlersBy($resolvedHandlers, $updateType, $this->update?->message?->getType());
            }
        } elseif ($updateType === UpdateTypes::CALLBACK_QUERY) {
            $data = $this->update->callback_query?->data;
            $this->addHandlersBy($resolvedHandlers, $updateType, value: $data);
        }

        if (empty($resolvedHandlers) && $updateType !== null) {
            $this->addHandlersBy($resolvedHandlers, $updateType);
        }

        $this->addHandlersBy($resolvedHandlers, Update::class);

        return $resolvedHandlers;
    }

    /**
     * @param  array  $handlers
     * @param  string  $type
     * @param  string|null  $subType
     * @param  null  $value
     */
    protected function addHandlersBy(array &$handlers, string $type, ?string $subType = null, $value = null): void
    {
        $typedHandlers = $this->handlers[$type] ?? [];

        if ($subType !== null && isset($typedHandlers[$subType])) {
            if ($typedHandlers[$subType] instanceof Handler) {
                $typedHandlers = [$typedHandlers[$subType]];
            } else {
                $typedHandlers = $typedHandlers[$subType];
            }
        }

        /** @var Handler|array $handler */
        foreach ($typedHandlers as $handler) {
            if (is_array($handler)) {
                continue;
            }
            if (
                ($subType !== null && $handler->getPattern() === $subType) ||
                ($value === null && $handler->getPattern() === null) ||
                ($value !== null && $handler->matching($value))
            ) {
                $handlers[] = $handler;
            }
        }
    }

    /**
     * @param  $conversation
     * @return array
     */
    protected function continueConversation($conversation): array
    {
        $resolvedHandlers = [];

        if (!$conversation instanceof Conversation || !$conversation->skipHandlers()) {
            $handlers = $this->resolveHandlers();

            /** @var Handler $handler */
            foreach ($handlers as $handler) {
                // if we found at least one specific handler,
                // we should escape the conversation
                if ($handler->getPattern() !== null) {
                    if ($conversation instanceof Conversation) {
                        $conversation->terminate($this);
                    }
                    return $handlers;
                }
            }
        }

        $handler = new Handler($conversation);

        if (!$conversation instanceof Conversation || !$conversation->skipMiddlewares()) {
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
