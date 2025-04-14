<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputProfilePhotoType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;

/**
 * This object describes a profile photo to set. Currently, it can be one of
 * - {@see InputProfilePhotoStatic}
 * - {@see InputProfilePhotoAnimated}
 */
abstract class InputProfilePhoto extends BaseType implements Uploadable
{
    #[EnumOrScalar]
    public InputProfilePhotoType|string $type;
}
