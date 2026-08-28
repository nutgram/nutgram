<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A quotation with centered text, loosely corresponding to the HTML tag <code><aside></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockpullquotation
 */
#[SkipConstructor]
class InputRichBlockPullQuotation extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “pullquote”
     */
    public InputRichBlockType|string $type = InputRichBlockType::PULLQUOTE;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    public string|array|RichText $text;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    public string|array|RichText|null $credit = null;

    /**
     * @param string|RichText[]|RichText $text
     * @param string|RichText[]|RichText|null $credit
     */
    public function __construct(string|array|RichText $text, string|array|RichText|null $credit = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->credit = $credit;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
