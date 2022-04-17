<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one result of an inline query.
 * Telegram clients currently support results of the following 20 types:
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedaudio InlineQueryResultCachedAudio}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcacheddocument InlineQueryResultCachedDocument}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedgif InlineQueryResultCachedGif}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedmpeg4gif InlineQueryResultCachedMpeg4Gif}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedphoto InlineQueryResultCachedPhoto}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedsticker InlineQueryResultCachedSticker}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedvideo InlineQueryResultCachedVideo}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcachedvoice InlineQueryResultCachedVoice}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultarticle InlineQueryResultArticle}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultaudio InlineQueryResultAudio}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultcontact InlineQueryResultContact}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultgame InlineQueryResultGame}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultdocument InlineQueryResultDocument}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultgif InlineQueryResultGif}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultlocation InlineQueryResultLocation}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif InlineQueryResultMpeg4Gif}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultphoto InlineQueryResultPhoto}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultvenue InlineQueryResultVenue}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultvideo InlineQueryResultVideo}
 * - {@see https://core.telegram.org/bots/api#inlinequeryresultvoice InlineQueryResultVoice}
 *
 * Note: All URLs passed in inline query results will be available to end users and
 * therefore must be assumed to be public.
 * @see https://core.telegram.org/bots/api#inlinequeryresult
 */
abstract class InlineQueryResult extends BaseType
{
}
