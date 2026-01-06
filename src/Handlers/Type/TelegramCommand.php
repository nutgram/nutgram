<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Handlers\Type;

interface TelegramCommand
{
    /**
     * Human-readable description of the command.
     *
     * When provided as a string, the same description is used for all locales.
     *
     * When provided as an array, the keys MUST be language codes (e.g. "en", "de")
     * and MAY include the special "*" key to define a default description that is
     * used when a more specific language code is not available.
     *
     * Example 1:
     * <code>
     * public function description(): string|array
     * {
     *     return "List your active subscriptions"; // all locales
     * }
     * </code>
     *
     * Example 2:
     * <code>
     * public function description(): string|array
     * {
     *     return [
     *        "en" => "List your active subscriptions",   // english locale
     *        "it" => "Elenca le sottoscrizioni attive",  // italian locale
     *        "*"  => "List your active subscriptions",   // all other locales
     *     ];
     * }
     * </code>
     * @return string|array<string,string>
     */
    public function description(): string|array;
}
