<?php

namespace SergiX44\Nutgram\Conversations;

use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\InlineKeyboardMarkup;

abstract class InlineMenu extends Conversation
{
    /**
     * @var int|null
     */
    protected ?int $messageId = null;

    /**
     * @var int|null
     */
    protected ?int $chatId = null;

    /**
     * @var string
     */
    protected string $text;

    /**
     * @var InlineKeyboardMarkup
     */
    protected InlineKeyboardMarkup $buttons;

    /**
     * @var array
     */
    protected array $callbacks = [];

    /**
     * @var string
     */
    protected string $orNext;

    public function __construct()
    {
        $this->buttons = InlineKeyboardMarkup::make();
    }

    /**
     * @param  string  $text
     * @return InlineMenu
     */
    public function menuText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return $this
     */
    public function clearButtons(): self
    {
        $this->buttons = InlineKeyboardMarkup::make();
        return $this;
    }

    /**
     * @param  InlineKeyboardButton  $buttons
     * @return InlineMenu
     */
    public function addButtonRow(...$buttons): self
    {
        foreach ($buttons as $button) {
            if ($button->callback_data === null) {
                continue;
            }

            if (str_starts_with($button->callback_data, '@')) {
                $button->callback_data = $button->text.$button->callback_data;
            }

            [$callbackData, $method] = explode('@', $button->callback_data ?? $button->text);

            if (!method_exists($this, $method)) {
                throw new InvalidArgumentException("The method $method does not exists.");
            }

            $button->callback_data = $callbackData;
            $this->callbacks[$callbackData] = $method;
        }

        $this->buttons->addRow(...$buttons);
        return $this;
    }

    /**
     * @param  string|null  $orNext
     * @return InlineMenu
     */
    public function orNext(?string $orNext): self
    {
        $this->orNext = $orNext;
        return $this;
    }

    /**
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handleStep(): mixed
    {
        $data = $this->bot->callbackQuery()?->data;

        if (isset($this->callbacks[$data]) && $this->bot->isCallbackQuery()) {
            $this->bot->answerCallbackQuery();
            $this->step = $data;
        } elseif (isset($this->orNext)) {
            $this->step = $this->orNext;
        } else {
            $this->end();
        }

        return $this($this->bot);
    }

    /**
     * @param  bool  $forceSend
     * @param  array  $opt
     * @param  bool  $noHandlers
     * @param  bool  $noMiddlewares
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function showMenu(array $opt = [], bool $forceSend = false, bool $noHandlers = false, bool $noMiddlewares = false): void
    {
        if ($forceSend || !$this->messageId || !$this->chatId) {
            $message = $this->bot->sendMessage($this->text, array_merge([
                'reply_markup' => $this->buttons,
            ], $opt));
        } else {
            $message = $this->bot->editMessageText($this->text, array_merge([
                'reply_markup' => $this->buttons,
            ], $opt));
        }

        $this->messageId = $message->message_id;
        $this->chatId = $message->chat?->id;

        $this->setSkipHandlers($noHandlers)
            ->setSkipMiddlewares($noMiddlewares)
            ->next('handleStep');
    }

    protected function closing(Nutgram $bot)
    {
        if ($this->messageId && $this->chatId) {
            $this->bot->deleteMessage($this->chatId, $this->messageId);
        }
    }
}
