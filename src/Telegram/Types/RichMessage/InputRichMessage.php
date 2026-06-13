<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a rich message to be sent.
 * Exactly one of the fields html or markdown must be used.
 * @see https://core.telegram.org/bots/api#inputrichmessage
 */
#[SkipConstructor]
class InputRichMessage extends BaseType
{
    /**
     * Optional. Content of the rich message to send described using HTML formatting.
     * See {@see https://core.telegram.org/bots/api#rich-message-formatting-options rich message formatting options} for more details.
     */
    public ?string $html = null;

    /**
     * Optional. Content of the rich message to send described using Markdown formatting.
     * See {@see https://core.telegram.org/bots/api#rich-message-formatting-options rich message formatting options} for more details.
     */
    public ?string $markdown = null;

    /**
     * Optional. Pass True if the rich message must be shown right-to-left
     */
    public ?bool $is_rtl = null;

    /**
     * Optional. Pass True to skip automatic detection of entities
     * (e.g., URLs, email addresses, username mentions, hashtags, cashtags, bot commands, or phone numbers) in the text
     */
    public ?bool $skip_entity_detection = null;

    public function __construct(
        ?string $html = null,
        ?string $markdown = null,
        ?bool $is_rtl = null,
        ?bool $skip_entity_detection = null,
    ) {
        parent::__construct();
        $this->html = $html;
        $this->markdown = $markdown;
        $this->is_rtl = $is_rtl;
        $this->skip_entity_detection = $skip_entity_detection;
    }
}
