<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the position of a clickable area within a story.
 * @see https://core.telegram.org/bots/api#storyareaposition
 */
#[SkipConstructor]
class StoryAreaPosition extends BaseType
{
    /**
     * The abscissa of the area's center, as a percentage of the media width
     */
    public float $x_percentage;

    /**
     * The ordinate of the area's center, as a percentage of the media height
     */
    public float $y_percentage;

    /**
     * The width of the area's rectangle, as a percentage of the media width
     */
    public float $width_percentage;

    /**
     * The height of the area's rectangle, as a percentage of the media height
     */
    public float $height_percentage;

    /**
     * The clockwise rotation angle of the rectangle, in degrees; 0-360
     */
    public float $rotation_angle;

    /**
     * The radius of the rectangle corner rounding, as a percentage of the media width
     */
    public float $corner_radius_percentage;

    public function __construct(
        float $x_percentage,
        float $y_percentage,
        float $width_percentage,
        float $height_percentage,
        float $rotation_angle,
        float $corner_radius_percentage
    ) {
        parent::__construct();
        $this->x_percentage = $x_percentage;
        $this->y_percentage = $y_percentage;
        $this->width_percentage = $width_percentage;
        $this->height_percentage = $height_percentage;
        $this->rotation_angle = $rotation_angle;
        $this->corner_radius_percentage = $corner_radius_percentage;
    }
}
