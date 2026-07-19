<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * Caption of a rich formatted block.
 * @see https://core.telegram.org/bots/api#richblockcaption
 */
#[SkipConstructor]
class RichBlockCaption extends BaseType implements JsonSerializable
{
    /**
     * Block caption
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, 16)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * Optional. Block credit which corresponds to the HTML tag <cite>
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class, 16)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $credit = null;

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
