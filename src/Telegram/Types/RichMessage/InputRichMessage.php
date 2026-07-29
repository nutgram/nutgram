<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlock;

/**
 * Describes a rich message to be sent.
 * Exactly one of the fields html, markdown, or blocks must be used.
 * @see https://core.telegram.org/bots/api#inputrichmessage
 */
#[OverrideConstructor('bindToInstance')]
class InputRichMessage extends BaseType
{
    /**
     * Optional. Content of the rich message to send described as a list of blocks
     * @var InputRichBlock[]|null
     */
    #[ArrayType(InputRichBlock::class)]
    public ?array $blocks = null;

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
     * Optional.
     * List of media that are specified in the markdown or html fields using tg://photo?id=, tg://video?id=, and tg://audio?id= links
     * @var InputRichMessageMedia[]|null
     */
    #[ArrayType(InputRichMessageMedia::class)]
    public ?array $media = null;

    /**
     * Optional. Pass True if the rich message must be shown right-to-left
     */
    public ?bool $is_rtl = null;

    /**
     * Optional. Pass True to skip automatic detection of entities
     * (e.g., URLs, email addresses, username mentions, hashtags, cashtags, bot commands, or phone numbers) in the text
     */
    public ?bool $skip_entity_detection = null;

    /**
     * @param string|null $html
     * @param string|null $markdown
     * @param bool|null $is_rtl
     * @param bool|null $skip_entity_detection
     * @param InputRichMessageMedia[]|null $media
     * @param InputRichBlock[]|null $blocks
     */
    public function __construct(
        ?string $html = null,
        ?string $markdown = null,
        ?bool $is_rtl = null,
        ?bool $skip_entity_detection = null,
        ?array $media = null,
        ?array $blocks = null
    ) {
        parent::__construct();
        $this->html = $html;
        $this->markdown = $markdown;
        $this->is_rtl = $is_rtl;
        $this->skip_entity_detection = $skip_entity_detection;
        $this->media = $media;
        $this->blocks = $blocks;
    }
}
