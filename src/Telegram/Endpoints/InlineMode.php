<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use JsonException;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResult;
use SergiX44\Nutgram\Telegram\Types\WebApp\SentWebAppMessage;

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
     * @param  array{
     *     cache_time?:int,
     *     is_personal?:bool,
     *     next_offset?:string,
     *     switch_pm_text?:string,
     *     switch_pm_parameter?:string
     * }  $opt
     * @return bool|null
     * @throws JsonException
     */
    public function answerInlineQuery(array $results, array $opt = []): ?bool
    {
        $required = [
            'inline_query_id' => $this->inlineQuery()?->id,
            'results' => json_encode($results, JSON_THROW_ON_ERROR),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to set the result of an interaction with a Web App and send a corresponding message
     * on behalf of the user to the chat from which the query originated.
     * On success, a {@see https://core.telegram.org/bots/api#sentwebappmessage SentWebAppMessage} object is returned.
     * @param  string  $web_app_query_id Unique identifier for the query to be answered
     * @param  InlineQueryResult  $result A JSON-serialized object describing the message to be sent
     * @return SentWebAppMessage|null
     * @throws JsonException
     */
    public function answerWebAppQuery(string $web_app_query_id, InlineQueryResult $result): ?SentWebAppMessage
    {
        return $this->requestJson(__FUNCTION__, [
            'web_app_query_id' => $web_app_query_id,
            'result' => json_encode($result, JSON_THROW_ON_ERROR),
        ], SentWebAppMessage::class);
    }
}
