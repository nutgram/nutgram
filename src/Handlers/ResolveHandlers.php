<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Proxies\UpdateProxy;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
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

    abstract public function getConfig(): array;

    /**
     * @return array
     */
    protected function resolveHandlers(): array
    {
        $resolvedHandlers = [];
        $updateType = $this->update->getType();

        if ($updateType === UpdateTypes::MESSAGE) {
            $messageType = $this->update->message->getType();

            if ($messageType === MessageTypes::TEXT) {
                $username = $this->getConfig()['bot_name'] ?? null;
                $text = $this->update?->message?->getParsedCommand($username) ?? $this->update->message?->text;

                if ($text !== null) {
                    $this->addHandlersBy($resolvedHandlers, $updateType, $messageType, $text);
                }
            } elseif ($messageType === MessageTypes::SUCCESSFUL_PAYMENT) {
                $data = $this->update->message->successful_payment?->invoice_payload;
                $this->addHandlersBy($resolvedHandlers, $updateType, $messageType, $data);
            }

            if (count($resolvedHandlers) === 0) {
                $this->addHandlersBy($resolvedHandlers, $updateType, $messageType);
            }
        } elseif ($updateType === UpdateTypes::CALLBACK_QUERY) {
            $data = $this->update->callback_query?->data;
            $this->addHandlersBy($resolvedHandlers, $updateType, value: $data);
        } elseif ($updateType === UpdateTypes::PRE_CHECKOUT_QUERY) {
            $data = $this->update->pre_checkout_query?->invoice_payload;
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
     * @param  string|null  $value
     */
    protected function addHandlersBy(
        array &$handlers,
        string $type,
        ?string $subType = null,
        ?string $value = null
    ): void {
        $typedHandlers = $this->handlers[$type] ?? [];
        $typedHandlers = is_array($typedHandlers) ? $typedHandlers : [$typedHandlers];

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
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return callable|Conversation|\Closure|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function currentConversation(?int $userId, ?int $chatId): callable|Conversation|\Closure|null
    {
        if ($chatId === null || $userId === null) {
            return null;
        }

        return $this->conversationCache->get($userId, $chatId);
    }

    /**
     * @param  Conversation|callable  $conversation
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function continueConversation(Conversation|callable $conversation): array
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
            $this->applyGlobalMiddlewareTo($handler);
        }

        $resolvedHandlers[] = $handler;

        return $resolvedHandlers;
    }

    /**
     * @param  Handler  $handler
     */
    protected function applyGlobalMiddlewareTo(Handler $handler): void
    {
        $this->applyGroupMiddlewares($handler);

        $skippedGlobalMiddlewares = $handler->getSkippedGlobalMiddlewares();

        if ($handler->isSkippingGlobalMiddlewares() && empty($skippedGlobalMiddlewares)) {
            return;
        }

        foreach ($this->globalMiddlewares as $middleware) {
            if ($handler->isSkippingGlobalMiddlewares() && in_array($middleware, $skippedGlobalMiddlewares, true)) {
                continue;
            }

            $handler->middleware($middleware);
        }
    }

    protected function applyGroupMiddlewares(Handler $handler): void
    {
        foreach (array_reverse($handler->getGroupMiddlewares()) as $middlewares) {
            foreach (array_reverse($middlewares) as $middleware) {
                $handler->middleware($middleware);
            }
        }
    }

    protected function applyGlobalMiddleware(): void
    {
        array_walk_recursive($this->handlers, function ($leaf) {
            if ($leaf instanceof Handler) {
                $this->applyGlobalMiddlewareTo($leaf);
            }
        });
    }
}
