<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\TestUnionResolver;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A preformatted text block, corresponding to the nested HTML tags <code><pre></code> and <code><code></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockpreformatted
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockPreformatted extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “pre”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PRE;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $text;

    /**
     * Optional. The programming language of the text
     */
    public ?string $language = null;

    public function __construct(string|array|RichText $text, ?string $language = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->language = $language;
    }
}
