<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;
use SergiX44\Nutgram\Telegram\Types\Media\Document;

/**
 * The background is a PNG or TGV (gzipped subset of SVG with MIME type “application/x-tgwallpattern”)
 * pattern to be combined with the background fill chosen by the user.
 * @see https://core.telegram.org/bots/api#backgroundtypepattern
 */
class BackgroundTypePattern extends BackgroundType
{
    /**
     * Type of the background, always “pattern”
     */
    #[EnumOrScalar]
    public BackgroundTypeType|string $type = BackgroundTypeType::PATTERN;

    /**
     * Document with the pattern
     */
    public Document $document;

    /**
     * The background fill that is combined with the pattern
     */
    public BackgroundFill $fill;

    /**
     * Intensity of the pattern when it is shown above the filled background; 0-100
     */
    public int $intensity;

    /**
     * Optional. True, if the background fill must be applied only to the pattern itself.
     * All other pixels are black in this case. For dark themes only
     */
    public ?bool $is_inverted = null;

    /**
     * Optional. True, if the background moves slightly when the device is tilted
     */
    public ?bool $is_moving = null;
}
