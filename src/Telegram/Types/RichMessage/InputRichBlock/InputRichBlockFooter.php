<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A footer, corresponding to the HTML tag <code><footer></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockfooter
 */
#[SkipConstructor]
class InputRichBlockFooter extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “footer”
     */
    public InputRichBlockType|string $type = InputRichBlockType::FOOTER;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    public string|array|RichText $text;

    /**
     * @param string|RichText[]|RichText $text
     */
    public function __construct(string|array|RichText $text)
    {
        parent::__construct();
        $this->text = $text;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
