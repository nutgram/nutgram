<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MaskPositionPoint;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the position on faces where a mask should be placed by default.
 * @see https://core.telegram.org/bots/api#maskposition
 */
#[SkipConstructor]
class MaskPosition extends BaseType implements JsonSerializable
{
    /**
     * The part of the face relative to which the mask should be placed.
     * One of “forehead”, “eyes”, “mouth”, or “chin”.
     */
    #[EnumOrScalar]
    public MaskPositionPoint|string $point;

    /**
     * Shift by X-axis measured in widths of the mask scaled to the face size, from left to right.
     * For example, choosing -1.0 will place mask just to the left of the default mask position.
     */
    public float $x_shift;

    /**
     * Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom.
     * For example, 1.0 will place the mask just below the default mask position.
     */
    public float $y_shift;

    /**
     * Mask scaling coefficient.
     * For example, 2.0 means double size.
     */
    public float $scale;

    public function __construct(
        MaskPositionPoint|string $point,
        float $x_shift,
        float $y_shift,
        float $scale,
    ) {
        parent::__construct();
        $this->point = $point;
        $this->x_shift = $x_shift;
        $this->y_shift = $y_shift;
        $this->scale = $scale;
    }

    public static function make(
        MaskPositionPoint|string $point,
        float $x_shift,
        float $y_shift,
        float $scale,
    ): self {
        return new self(
            point: $point,
            x_shift: $x_shift,
            y_shift: $y_shift,
            scale: $scale,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'point' => $this->point->value,
            'x_shift' => $this->x_shift,
            'y_shift' => $this->y_shift,
            'scale' => $this->scale,
        ];
    }
}
