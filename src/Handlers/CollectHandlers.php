<?php


namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

abstract class CollectHandlers
{
    protected const FALLBACK = 'FALLBACK';

    /**
     * @var array
     */
    protected array $globalMiddlewares = [];

    /**
     * @var array
     */
    protected array $handlers = [];

    /**
     * @var Handler|null
     */
    protected ?Handler $onException = null;

    /**
     * @var Handler|null
     */
    protected ?Handler $onApiError = null;

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
     * @return Handler
     */
    public function onCommand(string $command, $callable): Handler
    {
        $command = "/{$command}";

        return $this->handlers[UpdateTypes::MESSAGE][$command] = new Handler($callable, $command);
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
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->handlers[UpdateTypes::MESSAGE][$pattern] = new Handler($callable, $pattern);
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
    public function onException($callable): Handler
    {
        return $this->onException = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onApiError($callable): Handler
    {
        return $this->onApiError = new Handler($callable);
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
    public function fallbackOn(string $type, $callable)
    {
        if (!in_array($type, UpdateTypes::get())) {
            throw new InvalidArgumentException('The paramenter "type" is not a valid update type.');
        }
        return $this->handlers[self::FALLBACK][$type] = new Handler($callable, $type);
    }
}
