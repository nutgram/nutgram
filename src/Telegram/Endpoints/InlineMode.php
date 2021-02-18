<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;

/**
 * Trait InlineMode
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait InlineMode
{

    /**
     * @param  array  $results
     * @param  array|null  $opt
     * @return bool|null
     */
    public function answerInlineQuery(array $results, ?array $opt = []): ?bool
    {
        $required = [
            'inline_query_id' => $this->inlineQuery()?->id,
            'results' => json_encode($results),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

}