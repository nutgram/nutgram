<?php

namespace SergiX44\Nutgram\Conversations;

use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

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
    private string $text;

    /**
     * @var InlineKeyboardMarkup
     */
    private InlineKeyboardMarkup $buttons;

    /**
     * @var array
     */
    private array $callbacks = [];

    /**
     * @var string|null
     */
    private ?string $orNext;

    /**
     * @var array
     */
    private array $opt = [];

    /**
     * @var bool
     */
    private bool $withForceReopen = false;

    public function __construct()
    {
        $this->buttons = InlineKeyboardMarkup::make();
    }

    /**
     * @return array
     */
    protected function getSerializableAttributes(): array
    {
        return get_object_vars($this);
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
        $this->withForceReopen = false;
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
     * @param  bool  $withForceReopen
     * @return InlineMenu
     */
    protected function orNext(?string $orNext, bool $withForceReopen = false): self
    {
        $this->orNext = $orNext;
        $this->withForceReopen = $withForceReopen;
        return $this;
    }

    /**
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handleStep(): mixed
    {
        if ($this->bot->isCallbackQuery()) {
            $data = $this->bot->callbackQuery()?->data;

            $result = null;
            if (isset($this->callbacks[$data])) {
                $this->step = $this->callbacks[$data];
                $result = $this($this->bot, $data);
            }

            $this->bot->answerCallbackQuery();
            return $result;
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
     * @return Message|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function showMenu(
        bool $reopen = false,
        bool $noHandlers = false,
        bool $noMiddlewares = false
    ): Message|null {
        $reopen = $reopen || ($this->step === $this->orNext && $this->withForceReopen);

        if ($reopen || !$this->messageId || !$this->chatId) {
            if ($reopen) {
                $this->closeMenu();
                $this->withForceReopen = false;
            }
            $message = $this->doOpen($this->text, $this->buttons, $this->opt);
        } else {
            $message = $this->doUpdate($this->text, $this->chatId, $this->messageId, $this->buttons, $this->opt);
        }

        $this->messageId = $message?->message_id ?? $this->messageId;
        $this->chatId = $message?->chat?->id ?? $this->chatId;

        $this->setSkipHandlers($noHandlers)
            ->setSkipMiddlewares($noMiddlewares)
            ->next('handleStep');

        return $message;
    }

    /**
     * @param  string|null  $finalText
     * @param  array  $opt
     * @param  bool  $reopen
     * @return bool
     */
    protected function closeMenu(?string $finalText = null, array $opt = [], bool $reopen = false): bool
    {
        if ($this->messageId && $this->chatId && $reopen) {
            $this->chatId = $this->messageId = null;
        }

        if ($this->messageId && $this->chatId) {
            // if we have the final text, clear and update the last message
            if ($finalText !== null) {
                $this->clearButtons();
                $this->doUpdate($finalText, $this->chatId, $this->messageId, $this->buttons, $opt);
                $this->chatId = $this->messageId = null;
                return true;
            }

            // otherwise delete it as default
            try {
                $result = $this->doClose($this->chatId, $this->messageId);
                $this->chatId = $this->messageId = null;
                return $result;
            } catch (TelegramException) {
                return false;
            }
        }

        // if we have the final text but some reason not the message and chat
        // display it as a new message
        if ($finalText !== null) {
            $this->clearButtons();
            $this->doOpen($finalText, $this->buttons, $opt);
            $this->chatId = $this->messageId = null;
            return true;
        }

        return false;
    }

    /**
     * @param  Nutgram  $bot
     *
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
        $this->closeMenu();
    }

    /**
     * @param  string  $text
     * @param  InlineKeyboardMarkup  $buttons
     * @param  array  $opt
     * @return Message|null
     * @internal Override only to change the Telegram method.
     */
    protected function doOpen(string $text, InlineKeyboardMarkup $buttons, array $opt): Message|null
    {
        return $this->bot->sendMessage($text, array_merge([
            'reply_markup' => $buttons,
        ], $opt));
    }

    /**
     * @param  string  $text
     * @param  int|null  $chatId
     * @param  int|null  $messageId
     * @param  InlineKeyboardMarkup  $buttons
     * @param  array  $opt
     * @return Message|null
     * @internal Override only to change the Telegram method.
     */
    protected function doUpdate(
        string $text,
        ?int $chatId,
        ?int $messageId,
        InlineKeyboardMarkup $buttons,
        array $opt
    ): Message|null {
        return $this->bot->editMessageText($text, array_merge([
            'reply_markup' => $buttons,
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ], $opt));
    }

    /**
     * @param  int|null  $chatId
     * @param  int|null  $messageId
     * @return bool
     * @internal Override only to change the Telegram method.
     */
    protected function doClose(?int $chatId, ?int $messageId): bool
    {
        return $this->bot->deleteMessage($chatId, $messageId) ?? false;
    }
}
