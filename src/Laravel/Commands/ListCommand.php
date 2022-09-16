<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionProperty;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use Symfony\Component\Console\Terminal;

class ListCommand extends Command
{
    protected $signature = 'nutgram:list';

    protected $description = 'List all registered handlers';

    public function handle(): int
    {
        $bot = app(Nutgram::class);

        $refHandlers = new ReflectionProperty(Nutgram::class, "handlers");
        $refHandlers->setAccessible(true);

        $handlers = collect(Arr::dot($refHandlers->getValue($bot)))
            ->map(function (Handler $handler, string $key) {
                $refCallable = new ReflectionProperty(Handler::class, "callable");
                $refCallable->setAccessible(true);
                $callable = $refCallable->getValue($handler);

                return [
                    'handler' => $this->getHandlerName($key),
                    'arg' => $handler->getPattern(),
                    'subtype' => $this->getMessageSubtype($key),
                    'callable' => $this->getCallableName($callable),
                ];
            });

        if ($handlers->isEmpty()) {
            $this->warn("No handlers have been registered.");
            return 0;
        }

        $terminalWidth = (new Terminal)->getWidth();
        $padding = 2;
        $maxHandler = (int)$handlers->max(fn ($item) => strlen($item['handler'])) + 1;

        foreach ($handlers as $data) {
            [$handler, $arg, $subtype, $callable] = array_values($data);

            $handler = str_pad($handler ?? '', $maxHandler);
            $arg = (!in_array($handler, ['onText', 'onCommand']) ? $arg : $subtype);
            $arg = $arg ?: $subtype;

            $dots = str_repeat('.', max($terminalWidth - mb_strlen($handler . $arg . $callable) - ($padding * 2), 0));

            $output = "<fg=yellow>$handler</>";
            $output .= "<fg=gray>$arg</>";
            $output .= "<fg=blue>$dots</>";
            $output .= "<fg=blue>$callable</>";

            $output = str_repeat(' ', $padding) . $output . str_repeat(' ', $padding);

            $this->line($output);
        }

        return 0;
    }

    protected function getHandlerName(string $signature): ?string
    {
        $signature = Str::lower($signature);

        return match (Str::before($signature, '.')) {
            'message' => value(
                function () use ($signature) {
                    $subHandlerSignature = Str::after($signature, 'message.');
                    [$subHandlerName, $subHandlerKey] = array_pad(explode('.', $subHandlerSignature), 2, null);

                    if ($subHandlerName === 'text') {
                        if (Str::startsWith($subHandlerKey ?? '', '/')) {
                            return 'onCommand';
                        }

                        return 'onText';
                    }

                    if (!in_array($subHandlerName, MessageTypes::all(), true)) {
                        return 'onMessage';
                    }

                    return 'onMessageType';
                }
            ),
            'edited_message' => 'onEditedMessage',
            'channel_post' => 'onChannelPost',
            'edited_channel_post' => 'onEditedChannelPost',
            'inline_query' => 'onInlineQuery',
            'chosen_inline_result' => 'onChosenInlineResult',
            'callback_query' => 'onCallbackQuery',
            'shipping_query' => 'onShippingQuery',
            'pre_checkout_query' => 'onPreCheckoutQuery',
            'poll' => 'onPoll',
            'poll_answer' => 'onPollAnswer',
            'my_chat_member' => 'onMyChatMember',
            'chat_member' => 'onChatMember',
            'chat_join_request' => 'onChatJoinRequest',
            'api_error' => 'onApiError',
            'exception' => 'onException',
            default => null,
        };
    }

    protected function getMessageSubtype(string $value): ?string
    {
        $value = Str::lower($value);

        if (!Str::startsWith($value, 'message.')) {
            return null;
        }

        $subHandlerSignature = Str::after($value, 'message.');
        [$subHandlerName] = array_pad(explode('.', $subHandlerSignature), 1, null);

        if (!in_array($subHandlerName, MessageTypes::all(), true)) {
            return null;
        }

        return sprintf("MessageTypes::%s", Str::upper($subHandlerName ?? 'UNKNOWN'));
    }

    protected function getCallableName(mixed $callable): string
    {
        if (is_string($callable)) {
            return trim($callable);
        }

        if (is_array($callable)) {
            if (is_object($callable[0])) {
                return sprintf("%s::%s", get_class($callable[0]), trim($callable[1]));
            }

            return sprintf("%s::%s", trim($callable[0]), trim($callable[1]));
        }

        if ($callable instanceof Closure) {
            return 'closure';
        }

        return 'unknown';
    }
}
