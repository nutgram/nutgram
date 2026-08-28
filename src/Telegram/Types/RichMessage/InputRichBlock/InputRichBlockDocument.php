<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaDocument;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a general file, corresponding to the custom HTML tag &lt;tg-document&gt;.
 * @see https://core.telegram.org/bots/api#inputrichblockdocument
 */
#[SkipConstructor]
class InputRichBlockDocument extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “document”
     */
    public InputRichBlockType|string $type = InputRichBlockType::DOCUMENT;

    /**
     * The document. Caption is ignored.
     */
    public InputMediaDocument $document;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaDocument $document, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->document = $document;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
