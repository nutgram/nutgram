<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Document;

/**
 * A block with a general file, corresponding to the custom HTML tag &lt;tg-document&gt;.
 * @see https://core.telegram.org/bots/api#richblockdocument
 */
class RichBlockDocument extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “document”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::DOCUMENT;

    /**
     * The document
     */
    public Document $document;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
