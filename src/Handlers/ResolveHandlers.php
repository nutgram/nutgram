<?php


namespace SergiX44\Nutgram\Handlers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Proxies\UpdateProxy;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
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

    abstract public function getConfig(): Configuration;

    abstract public function getContainer(): Container;

    /**
     * @param int|null $userId
     * @param int|null $chatId
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
     * @return array
     */
    protected function resolveHandlers(): array
    {
        $resolvedHandlers = [];
        $updateType = $this->update?->getType();

        if ($updateType?->isMessageType()) {
            $messageType = $this->update->getMessage()?->getType();

            if ($messageType === MessageType::TEXT) {
                $username = $this->getConfig()->botName;
                $text = $this->update?->getMessage()?->getParsedCommand($username) ?? $this->update->getMessage()?->text;

                if ($text !== null) {
                    $this->addHandlersBy($resolvedHandlers, $updateType->value, $messageType->value, $text);
                }
            } elseif ($messageType === MessageType::SUCCESSFUL_PAYMENT) {
                $data = $this->update->getMessage()->successful_payment?->invoice_payload;
                $this->addHandlersBy($resolvedHandlers, $updateType->value, $messageType->value, $data);
            } elseif ($messageType === MessageType::REFUNDED_PAYMENT) {
                $data = $this->update->getMessage()->refunded_payment?->invoice_payload;
                $this->addHandlersBy($resolvedHandlers, $updateType->value, $messageType->value, $data);
            }

            if (count($resolvedHandlers) === 0) {
                $this->addHandlersBy($resolvedHandlers, $updateType->value, $messageType?->value);
            }
        } elseif ($updateType === UpdateType::CALLBACK_QUERY) {
            $data = $this->update->callback_query?->data;
            $this->addHandlersBy($resolvedHandlers, $updateType->value, value: $data);
        } elseif ($updateType === UpdateType::CHOSEN_INLINE_RESULT) {
            $data = $this->chosenInlineResult()?->query;
            $this->addHandlersBy($resolvedHandlers, $updateType->value, value: $data);
        } elseif ($updateType === UpdateType::PRE_CHECKOUT_QUERY) {
            $data = $this->update->pre_checkout_query?->invoice_payload;
            $this->addHandlersBy($resolvedHandlers, $updateType->value, value: $data);
        } elseif ($updateType === UpdateType::INLINE_QUERY) {
            $data = $this->update->inline_query?->query;
            $this->addHandlersBy($resolvedHandlers, $updateType->value, value: $data);
        } elseif ($updateType === UpdateType::PURCHASED_PAID_MEDIA) {
            $data = $this->update->purchased_paid_media?->paid_media_payload;
            $this->addHandlersBy($resolvedHandlers, $updateType->value, value: $data);
        }

        if (empty($resolvedHandlers) && $updateType !== null) {
            $this->addHandlersBy($resolvedHandlers, $updateType->value);
        }

        $this->addHandlersBy($resolvedHandlers, Update::class);

        return $resolvedHandlers;
    }

    /**
     * @param array $handlers
     * @param string $type
     * @param string|null $subType
     * @param string|null $value
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
            if (is_array($handler) || $handler->isDisabled()) {
                continue;
            }

            if (
                ($subType !== null && $handler->getPattern() === $subType) ||
                ($value === null && $handler->getPattern() === null) ||
                ($value !== null && $handler->matching($value, $this->getContainer()))
            ) {
                $handlers[] = $handler;
            }
        }
    }

    /**
     * @param Conversation|callable $conversation
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

        if ($conversation instanceof Conversation && $conversation->shouldRefreshInstance()) {
            $this->refreshInstance($conversation);
        }

        $handler = new Handler($conversation);

        if (!$conversation instanceof Conversation || !$conversation->skipMiddlewares()) {
            $this->applyGlobalMiddlewareTo($handler);
        }

        $resolvedHandlers[] = $handler;

        return $resolvedHandlers;
    }

    /**
     * @param Handler $handler
     */
    protected function applyGlobalMiddlewareTo(Handler $handler): void
    {
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

    protected function applyGlobalMiddleware(): void
    {
        array_walk_recursive($this->handlers, function ($leaf) {
            if ($leaf instanceof Handler) {
                $this->applyGlobalMiddlewareTo($leaf);
            }
        });
    }

    /**
     * @param Conversation $conversation
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function refreshInstance(Conversation $conversation): void
    {
        $getAttributes = fn () => array_filter(get_object_vars($this));
        $setAttributes = function (array $attributes) {
            foreach ($attributes as $attribute => $value) {
                $this->{$attribute} = $value;
            }
        };

        $freshConversation = $this->container->get($conversation::class);
        $freshAttributes = $getAttributes->call($freshConversation);
        $currentAttributes = $getAttributes->call($conversation);
        $attributes = array_diff_key($freshAttributes, $currentAttributes);
        $setAttributes->call($conversation, $attributes);
    }

    protected function resolveGroups(): void
    {
        $this->target = 'groupHandlers';

        // retrieve the starting groups and reset global state
        $groups = $this->groups;
        $this->groups = [];

        $this->resolveNestedGroups($groups);
    }

    /**
     * @param HandlerGroup[] $groups
     * @param array $currentMiddlewares
     * @param array $currentScopes
     * @return void
     */
    private function resolveNestedGroups(
        array $groups,
        array $currentMiddlewares = [],
        array $currentScopes = [],
        array $currentTags = [],
        array $currentConstraints = [],
    ) {
        foreach ($groups as $group) {
            $middlewares = [...$group->getMiddlewares(), ...$currentMiddlewares,];
            $scopes = [...$currentScopes, ...$group->getScopes()];
            $tags = [...$currentTags, ...$group->getTags()];
            $constraints = [...$currentConstraints, ...$group->getConstraints()];
            $this->groupHandlers = [];
            ($group->groupCallable)($this);

            // apply the middleware stack to the current registered group handlers
            array_walk_recursive(
                $this->groupHandlers,
                function ($leaf) use ($constraints, $tags, $middlewares, $scopes, $group) {
                    if ($leaf instanceof Handler) {
                        foreach ($middlewares as $middleware) {
                            $leaf->middleware($middleware);
                        }
                        if ($leaf instanceof Command && !empty($scopes)) {
                            $leaf->scope($scopes);
                        }
                        $leaf->tags([...$leaf->getTags(), ...$tags]);
                        $leaf->unless($group->isDisabled());
                        $leaf->where($constraints);
                    }
                }
            );

            $this->handlers = array_merge_recursive($this->handlers, $this->groupHandlers);

            if (!empty($this->groups)) {
                $groups = $this->groups;
                $this->groups = [];
                $this->resolveNestedGroups($groups, $middlewares, $scopes, $tags);
            }
        }
    }
}
