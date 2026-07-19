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
 * A footer, corresponding to the HTML tag <code><footer></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockfooter
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockFooter extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “footer”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::FOOTER;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $text;

public function __construct(string|array|RichText $text)
    {
        parent::__construct();
        $this->text = $text;
    }
}
