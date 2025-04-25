<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the options used for link preview generation.
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 */
#[OverrideConstructor('bindToInstance')]
class LinkPreviewOptions extends BaseType
{
    /**
     * Optional. True, if the link preview is disabled
     * @var bool|null
     */
    public ?bool $is_disabled = null;

    /**
     * Optional. URL to use for the link preview. If empty, then the first URL found in the message text will be used
     * @var string|null
     */
    public ?string $url = null;

    /**
     * Optional. True, if the media in the link preview is supposed to be shrunk; ignored if the URL isn't explicitly specified or media size change isn't supported for the preview
     * @var bool|null
     */
    public ?bool $prefer_small_media = null;

    /**
     * Optional. True, if the media in the link preview is supposed to be enlarged; ignored if the URL isn't explicitly specified or media size change isn't supported for the preview
     * @var bool|null
     */
    public ?bool $prefer_large_media = null;

    /**
     * Optional. True, if the link preview must be shown above the message text; otherwise, the link preview will be shown below the message text
     * @var bool|null
     */
    public ?bool $show_above_text = null;

    public function __construct(
        ?bool $is_disabled = null,
        ?string $url = null,
        ?bool $prefer_small_media = null,
        ?bool $prefer_large_media = null,
        ?bool $show_above_text = null
    ) {
        parent::__construct();
        $this->is_disabled = $is_disabled;
        $this->url = $url;
        $this->prefer_small_media = $prefer_small_media;
        $this->prefer_large_media = $prefer_large_media;
        $this->show_above_text = $show_above_text;
    }
}
