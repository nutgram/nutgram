<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultsButton;
use SergiX44\Nutgram\Telegram\Types\WebApp\SentWebAppMessage;

/**
 * Trait InlineMode
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait InlineMode
{
    /**
     * Use this method to send answers to an inline query.
     * On success, True is returned.No more than 50 results per query are allowed.
     * @see https://core.telegram.org/bots/api#answerinlinequery
     * @param InlineQueryResult[] $results A JSON-serialized array of results for the inline query
     * @param string|null $inline_query_id Unique identifier for the answered query
     * @param int|null $cache_time The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     * @param bool|null $is_personal Pass True if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query.
     * @param string|null $next_offset Pass the offset that a client should send in the next query with the same text to receive more results. Pass an empty string if there are no more results or if you don't support pagination. Offset length can't exceed 64 bytes.
     * @param InlineQueryResultsButton|null $button A JSON-serialized object describing a button to be shown above inline query results
     * @return bool|null
     */
    public function answerInlineQuery(
        array $results,
        ?string $inline_query_id = null,
        ?int $cache_time = null,
        ?bool $is_personal = null,
        ?string $next_offset = null,
        ?InlineQueryResultsButton $button = null,
    ): ?bool {
        $inline_query_id ??= $this->inlineQuery()?->id;
        $parameters = compact(
            'inline_query_id',
            'results',
            'cache_time',
            'is_personal',
            'next_offset',
            'button'
        );
        $parameters['results'] = json_encode($results, JSON_THROW_ON_ERROR);

        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * Use this method to set the result of an interaction with a {@see https://core.telegram.org/bots/webapps Web App} and send a corresponding message on behalf of the user to the chat from which the query originated.
     * On success, a {@see https://core.telegram.org/bots/api#sentwebappmessage SentWebAppMessage} object is returned.
     * @see https://core.telegram.org/bots/api#answerwebappquery
     * @param string $web_app_query_id Unique identifier for the query to be answered
     * @param InlineQueryResult $result A JSON-serialized object describing the message to be sent
     * @return SentWebAppMessage|null
     */
    public function answerWebAppQuery(string $web_app_query_id, InlineQueryResult $result): ?SentWebAppMessage
    {
        $parameters = compact('web_app_query_id', 'result');
        $parameters['result'] = json_encode($result, JSON_THROW_ON_ERROR);

        return $this->requestJson(__FUNCTION__, $parameters, SentWebAppMessage::class);
    }
}
