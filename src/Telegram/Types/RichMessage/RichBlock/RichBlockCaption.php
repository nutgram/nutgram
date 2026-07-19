<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\RichTextUnionResolver;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * Caption of a rich formatted block.
 * @see https://core.telegram.org/bots/api#richblockcaption
 */
#[OverrideConstructor('bindToInstance')]
class RichBlockCaption extends BaseType
{
    /**
     * Block caption
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * Optional. Block credit which corresponds to the HTML tag <cite>
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $credit = null;

    public function __construct(string|array|RichText $text, string|array|RichText|null $credit = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->credit = $credit;
    }
}
