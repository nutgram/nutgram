<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use JsonException;
use SergiX44\Nutgram\Telegram\Client;

/**
 * Trait InlineMode
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait InlineMode
{

    /**
     * Use this method to send answers to an inline query. On success, True is returned.
     * No more than 50 results per query are allowed.
     * @see https://core.telegram.org/bots/api#answerinlinequery
     * @param  array  $results An array of results for the inline query
     * @param  array|null  $opt
     * @return bool|null
     * @throws JsonException
     */
    public function answerInlineQuery(array $results, ?array $opt = []): ?bool
    {
        $required = [
            'inline_query_id' => $this->inlineQuery()?->id,
            'results' => json_encode($results, JSON_THROW_ON_ERROR),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }
}
