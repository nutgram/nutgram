<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaDocument;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadables;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a general file, corresponding to the custom HTML tag &lt;tg-document&gt;.
 * @see https://core.telegram.org/bots/api#inputrichblockdocument
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockDocument extends BaseType implements InputRichBlock, Uploadables
{
    /**
     * Type of the block, always “document”
     */
    #[EnumOrScalar]
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

    public function uploadables(): array
    {
        return ['document' => $this->document];
    }
}
