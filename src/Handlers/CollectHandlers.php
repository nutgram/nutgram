<?php


namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

abstract class CollectHandlers
{
    protected const FALLBACK = 'FALLBACK';
    protected const EXCEPTION = 'EXCEPTION';
    protected const API_ERROR = 'API_ERROR';

    /**
     * @var array
     */
    protected array $globalMiddlewares = [];

    /**
     * @var array
     */
    protected array $handlers = [];

    /**
     * @param $callable
     */
    public function middleware($callable): void
    {
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param  string  $command
     * @param $callable
     * @return Command
     */
    public function onCommand(string $command, $callable): Command
    {
        $command = "/$command";

        return $this->handlers[UpdateTypes::MESSAGE][MessageTypes::TEXT][$command] = new Command($callable, $command);
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
    public function onMessage($callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][] = new Handler($callable);
    }

    /**
     * @param  string  $type
     * @param $callable
     * @return Handler
     */
    public function onMessageType(string $type, $callable): Handler
    {
        if (!in_array($type, MessageTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid message type.');
        }
        return $this->handlers[UpdateTypes::MESSAGE][$type][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::CALLBACK_QUERY][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::CALLBACK_QUERY][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        return $this->handlers[UpdateTypes::EDITED_MESSAGE][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHANNEL_POST][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        return $this->handlers[UpdateTypes::EDITED_CHANNEL_POST][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::INLINE_QUERY][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHOSEN_INLINE_RESULT][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::SHIPPING_QUERY][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        return $this->handlers[UpdateTypes::PRE_CHECKOUT_QUERY][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPoll($callable): Handler
    {
        return $this->handlers[UpdateTypes::POLL][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        return $this->handlers[UpdateTypes::POLL_ANSWER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMyChatMember($callable): Handler
    {
        return $this->handlers[UpdateTypes::MY_CHAT_MEMBER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatMember($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHAT_MEMBER][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChatJoinRequest($callable): Handler
    {
        return $this->handlers[UpdateTypes::CHAT_JOIN_REQUEST][] = new Handler($callable);
    }

    /**
     * @param  callable|string  $callableOrException
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onException($callableOrException, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->handlers[self::EXCEPTION][$callableOrException] = new Handler($callable, $callableOrException);
        }

        return $this->handlers[self::EXCEPTION][] = new Handler($callableOrException);
    }

    /**
     * @param  callable|string  $callableOrPattern
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->handlers[self::API_ERROR][$callableOrPattern] = new Handler($callable, $callableOrPattern);
        }

        return $this->handlers[self::API_ERROR][] = new Handler($callableOrPattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function fallback($callable): Handler
    {
        return $this->handlers[self::FALLBACK][] = new Handler($callable);
    }

    /**
     * @param  string  $type
     * @param $callable
     * @return Handler
     */
    public function fallbackOn(string $type, $callable): Handler
    {
        if (!in_array($type, UpdateTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid update type.');
        }
        return $this->handlers[self::FALLBACK][$type] = new Handler($callable, $type);
    }

    /**
     * @param  bool  $exception
     * @param  bool  $apiError
     * @return void
     */
    public function clearErrorHandlers(bool $exception = true, bool $apiError = true): void
    {
        if ($exception) {
            $this->handlers[self::EXCEPTION] = [];
        }

        if ($apiError) {
            $this->handlers[self::API_ERROR] = [];
        }
    }
}
