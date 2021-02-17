<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\ExtendedTypes\ChannelPost;
use SergiX44\Nutgram\Telegram\ExtendedTypes\EditedChannelPost;
use SergiX44\Nutgram\Telegram\ExtendedTypes\EditedMessage;
use SergiX44\Nutgram\Telegram\Types\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Poll;
use SergiX44\Nutgram\Telegram\Types\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\ShippingQuery;

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

        return $this->handlers[Message::class][$command] = new Handler($callable, $command);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessage($callable): Handler
    {
        return $this->handlers[Message::class][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->handlers[Message::class][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onCallbackQuery($callable): Handler
    {
        return $this->handlers[CallbackQuery::class][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onCallbackQueryData(string $pattern, $callable): Handler
    {
        return $this->handlers[CallbackQuery::class][$pattern] = new Handler($callable, $pattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedMessage($callable): Handler
    {
        return $this->handlers[EditedMessage::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChannelPost($callable): Handler
    {
        return $this->handlers[ChannelPost::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onEditedChannelPost($callable): Handler
    {
        return $this->handlers[EditedChannelPost::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onInlineQuery($callable): Handler
    {
        return $this->handlers[InlineQuery::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onChosenInlineResult($callable): Handler
    {
        return $this->handlers[ChosenInlineResult::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onShippingQuery($callable): Handler
    {
        return $this->handlers[ShippingQuery::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPreCheckoutQuery($callable): Handler
    {
        return $this->handlers[PreCheckoutQuery::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPoll($callable): Handler
    {
        return $this->handlers[Poll::class][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onPollAnswer($callable): Handler
    {
        return $this->handlers[PollAnswer::class][] = new Handler($callable);
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
        return $this->handlers[self::FALLBACK] = new Handler($callable);
    }
}
