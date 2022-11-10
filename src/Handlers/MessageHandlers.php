<?php

namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Handlers\Type\CommandHandler;
use SergiX44\Nutgram\Support\Command;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

/**
 * @mixin CollectHandlers
 */
trait MessageHandlers
{
    /**
     * @param  string  $command
     * @param $callable
     * @return CommandHandler
     */
    public function onCommand(string $command, $callable = null): CommandHandler
    {
        if (is_subclass_of($command, Command::class)) {
            $commandName = "/{$command::$name}";
            $handler = new CommandHandler($command, $commandName);
            $handler->description($command::$description);
            array_walk($command::$middlewares, fn ($middleware) => $handler->middleware($middleware));
            if ($command::$skipGlobalMiddlewares !== null) {
                $handler->skipGlobalMiddlewares($command::$skipGlobalMiddlewares);
            }
        } else {
            if ($callable === null) {
                throw new InvalidArgumentException('You must provide a callable');
            }
            $commandName = "/$command";
            $handler = new CommandHandler($callable, $commandName);
        }

        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::TEXT][$commandName] = $handler;
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::TEXT][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPayment($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onSuccessfulPaymentPayload(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::SUCCESSFUL_PAYMENT][$pattern] = new Handler(
            $callable,
            $pattern
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicCreated($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CREATED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicClosed($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_CLOSED][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onForumTopicReopened($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::FORUM_TOPIC_REOPENED][] = new Handler($callable);
    }
}
