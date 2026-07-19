<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAnimation;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAudio;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVoiceNote;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\TestUnionResolver;

/**
 * Describes a media element embedded in an outgoing rich message.
 * @see https://core.telegram.org/bots/api#inputrichmessagemedia
 */
class InputRichMessageMedia extends BaseType
{
    /**
     * Unique identifier of the media used in a
     * tg://photo?id=, tg://video?id=, or tg://audio?id= link.
     * 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.
     */
    public string $id;

    /**
     * The message to be sent
     */
    #[TestUnionResolver]
    public InputMediaAnimation|InputMediaAudio|InputMediaPhoto|InputMediaVideo|InputMediaVoiceNote $media;
}
