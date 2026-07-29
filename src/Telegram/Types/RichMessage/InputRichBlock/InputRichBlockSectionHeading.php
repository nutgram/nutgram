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
 * A section heading, corresponding to the HTML tags
 * <code><h1></code>, <code><h2></code>, <code><h3></code>, <code><h4></code>, <code><h5></code>, or <code><h6></code>.
 * @see https://core.telegram.org/bots/api#inputrichblocksectionheading
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockSectionHeading extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “heading”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::HEADING;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $text;

    /**
     * Relative size of the text font; 1-6, 1 is the largest, 6 is the smallest
     */
    public int $size;

    public function __construct(string|array|RichText $text, int $size)
    {
        parent::__construct();
        $this->text = $text;
        $this->size = $size;
    }
}
