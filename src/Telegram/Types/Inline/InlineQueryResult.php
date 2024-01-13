<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one result of an inline query.
 * Telegram clients currently support results of the following 20 types:
 * - {@see InlineQueryResultCachedAudio InlineQueryResultCachedAudio}
 * - {@see InlineQueryResultCachedDocument InlineQueryResultCachedDocument}
 * - {@see InlineQueryResultCachedGif InlineQueryResultCachedGif}
 * - {@see InlineQueryResultCachedMpeg4Gif InlineQueryResultCachedMpeg4Gif}
 * - {@see InlineQueryResultCachedPhoto InlineQueryResultCachedPhoto}
 * - {@see InlineQueryResultCachedSticker InlineQueryResultCachedSticker}
 * - {@see InlineQueryResultCachedVideo InlineQueryResultCachedVideo}
 * - {@see InlineQueryResultCachedVoice InlineQueryResultCachedVoice}
 * - {@see InlineQueryResultArticle InlineQueryResultArticle}
 * - {@see InlineQueryResultAudio InlineQueryResultAudio}
 * - {@see InlineQueryResultContact InlineQueryResultContact}
 * - {@see InlineQueryResultGame InlineQueryResultGame}
 * - {@see InlineQueryResultDocument InlineQueryResultDocument}
 * - {@see InlineQueryResultGif InlineQueryResultGif}
 * - {@see InlineQueryResultLocation InlineQueryResultLocation}
 * - {@see InlineQueryResultMpeg4Gif InlineQueryResultMpeg4Gif}
 * - {@see InlineQueryResultPhoto InlineQueryResultPhoto}
 * - {@see InlineQueryResultVenue InlineQueryResultVenue}
 * - {@see InlineQueryResultVideo InlineQueryResultVideo}
 * - {@see InlineQueryResultVoice InlineQueryResultVoice}
 *
 * Note: All URLs passed in inline query results will be available to end users and
 * therefore must be assumed to be public.
 * @see https://core.telegram.org/bots/api#inlinequeryresult
 */
abstract class InlineQueryResult extends BaseType implements JsonSerializable
{
    /** Type of the result */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type;
}
