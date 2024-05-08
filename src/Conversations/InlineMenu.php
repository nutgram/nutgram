<?php

namespace SergiX44\Nutgram\Conversations;

use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Limits;
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
     * @var array
     */
    private array $callbackQueryOpt = [];

    public function __construct()
    {
        $this->buttons = InlineKeyboardMarkup::make();
    }

    /**
     * @return array
     */
    protected function getSerializableAttributes(): array
    {
        $attributes = get_object_vars($this);
        unset($attributes['callbackQueryOpt']);
        return $attributes;
    }

    /**
     * @param string $text
     * @param array $opt
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
     * @param InlineKeyboardButton $buttons
     * @return InlineMenu
     */
    protected function addButtonRow(...$buttons): self
    {
        foreach ($buttons as $button) {
            if ($button->callback_data === null || !str_contains($button->callback_data, '@')) {
                continue;
            }

            if (str_starts_with($button->callback_data, '@')) {
                $button->callback_data = substr($button->text, 0, Limits::CALLBACK_DATA_LENGTH).$button->callback_data;
            }

            @[$callbackData, $method] = explode('@', $button->callback_data);

            if (!method_exists($this, $method)) {
                throw new InvalidArgumentException("The method $method does not exists.");
            }

            while (array_key_exists($callbackData, $this->callbacks)) {
                $callbackData .= '@';
            }

            $button->callback_data = $callbackData;
            $this->callbacks[$callbackData] = $method;
        }

        $this->buttons->addRow(...$buttons);
        return $this;
    }

    /**
     * @param string|null $orNext
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
        if ($this->bot->isCallbackQuery()) {
            $data = $this->bot->callbackQuery()?->data;

            $result = null;
            if (isset($this->callbacks[$data])) {
                $this->step = $this->callbacks[$data];
                $data = trim($data, '@');
                $this->bot->callbackQuery()->data = $data;
                $result = $this($this->bot, $data);
            }

            $this->bot->answerCallbackQuery(...$this->callbackQueryOpt);
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
     * @param bool $reopen
     * @param bool $noHandlers
     * @param bool $noMiddlewares
     * @return Message|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function showMenu(
        bool $reopen = false,
        bool $noHandlers = false,
        bool $noMiddlewares = false
    ): Message|null {
        if ($reopen || !$this->messageId || !$this->chatId) {
            if ($reopen) {
                $this->closeMenu();
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

    protected function beforeStep(Nutgram $bot)
    {
        parent::beforeStep($bot);

        if ($this->chatId === null) {
            $this->chatId = $this->getChatId();
        }
    }

    /**
     * @param string|null $finalText
     * @param array $opt
     * @param bool $reopen
     *
     * @return Message|bool
     */
    protected function closeMenu(?string $finalText = null, array $opt = [], bool $reopen = false): bool|Message
    {
        if ($reopen) {
            $this->chatId = $this->messageId = null;
        }

        $result = false;
        if ($finalText !== null) {
            $this->clearButtons();
            if ($this->messageId && $this->chatId) {
                $result = $this->doUpdate($finalText, $this->chatId, $this->messageId, $this->buttons, $opt);
            } else {
                $result = $this->doOpen($finalText, $this->buttons, $opt);
            }
            $this->chatId = $this->messageId = null;
            return $result ?? true;
        }

        if ($this->messageId && $this->chatId) {
            try {
                $result = $this->doClose($this->chatId, $this->messageId);
                $this->chatId = $this->messageId = null;
            } catch (TelegramException) {
            }
        }

        return $result;
    }

    /**
     * @param array $opt
     * @return $this
     */
    protected function setCallbackQueryOptions(array $opt): self
    {
        $this->callbackQueryOpt = $opt;
        return $this;
    }

    /**
     * @param Nutgram $bot
     *
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
        $this->closeMenu();
    }

    /**
     * @param string $text
     * @param InlineKeyboardMarkup $buttons
     * @param array $opt
     * @return Message|null
     * @internal Override only to change the Telegram method.
     */
    protected function doOpen(string $text, InlineKeyboardMarkup $buttons, array $opt): Message|null
    {
        return $this->bot->sendMessage(...[
            'reply_markup' => $buttons,
            'text' => $text,
            'chat_id' => $this->chatId,
            ...$opt,
        ]);
    }

    /**
     * @param string $text
     * @param int|null $chatId
     * @param int|null $messageId
     * @param InlineKeyboardMarkup $buttons
     * @param array $opt
     *
     * @return Message|bool|null
     *
     * @internal Override only to change the Telegram method.
     */
    protected function doUpdate(
        string $text,
        ?int $chatId,
        ?int $messageId,
        InlineKeyboardMarkup $buttons,
        array $opt
    ): bool|Message|null {
        return $this->bot->editMessageText(...[
            'reply_markup' => $buttons,
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            ...$opt,
        ]);
    }

    /**
     * @param int $chatId
     * @param int $messageId
     * @return bool
     * @internal Override only to change the Telegram method.
     */
    protected function doClose(int $chatId, int $messageId): bool
    {
        return $this->bot->deleteMessage($chatId, $messageId) ?? false;
    }
}
