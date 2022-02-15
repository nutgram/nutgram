<?php

namespace SergiX44\Nutgram\Conversations;

use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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
     * @var string|null
     */
    protected ?string $orNext;

    /**
     * @var array
     */
    protected array $opt = [];

    public function __construct()
    {
        $this->buttons = InlineKeyboardMarkup::make();
    }

    /**
     * @param  string  $text
     * @param  array  $opt
     * @return InlineMenu
     */
    protected function menuText(string $text, array $opt = []): self
    {
        $this->text = $text;
        $this->opt = $opt;
        return $this;
    }

    /**
     * @return $this
     */
    protected function clearButtons(): self
    {
        $this->buttons = InlineKeyboardMarkup::make();
        $this->callbacks = [];
        $this->orNext = null;
        return $this;
    }

    /**
     * @param  InlineKeyboardButton  $buttons
     * @return InlineMenu
     */
    protected function addButtonRow(...$buttons): self
    {
        foreach ($buttons as $button) {
            if ($button->callback_data === null || !str_contains($button->callback_data, '@')) {
                continue;
            }

            if (str_starts_with($button->callback_data, '@')) {
                $button->callback_data = $button->text.$button->callback_data;
            }

            @[$callbackData, $method] = explode('@', $button->callback_data ?? $button->text);

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
    protected function orNext(?string $orNext): self
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
            $this->step = $this->callbacks[$data];
            return $this($this->bot, $data);
        }

        if (isset($this->orNext)) {
            $this->step = $this->orNext;
            return $this($this->bot);
        }

        $this->end();
        return null;
    }

    /**
     * @param  bool  $reopen
     * @param  bool  $noHandlers
     * @param  bool  $noMiddlewares
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function showMenu(bool $reopen = false, bool $noHandlers = false, bool $noMiddlewares = false): void
    {
        if ($reopen || !$this->messageId || !$this->chatId) {
            if ($reopen) {
                $this->closeMenu();
            }
            $message = $this->bot->sendMessage($this->text, array_merge([
                'reply_markup' => $this->buttons,
            ], $this->opt));
        } else {
            $message = $this->bot->editMessageText($this->text, array_merge([
                'reply_markup' => $this->buttons,
            ], $this->opt));
        }

        $this->messageId = $message?->message_id ?? $this->messageId;
        $this->chatId = $message?->chat?->id ?? $this->chatId;

        $this->setSkipHandlers($noHandlers)
            ->setSkipMiddlewares($noMiddlewares)
            ->next('handleStep');
    }

    /**
     * @return bool
     */
    protected function closeMenu(): bool
    {
        if ($this->messageId && $this->chatId) {
            try {
                return $this->bot->deleteMessage($this->chatId, $this->messageId) ?? false;
            } catch (TelegramException) {
                return false;
            }
        }
        return false;
    }

    /**
     * @param Nutgram  $bot
     *
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
        $this->closeMenu();
    }
}
