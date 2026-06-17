<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A block with a mathematical expression in LaTeX format, corresponding to the custom HTML tag <code><tg-math-block></code>.
 * @see https://core.telegram.org/bots/api#richblockmathematicalexpression
 */
class RichBlockMathematicalExpression extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “mathematical_expression”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::MATHEMATICAL_EXPRESSION;

    /**
     * The mathematical expression in LaTeX format
     */
    public string $expression;
}
