<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputStoryContentType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the content of a story to post. Currently, it can be one of
 * - {@see InputStoryContentPhoto}
 * - {@see InputStoryContentVideo}
 * @see https://core.telegram.org/bots/api#inputstorycontent
 */
abstract class InputStoryContent extends BaseType implements JsonSerializable
{
    #[EnumOrScalar]
    public InputStoryContentType|string $type;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
