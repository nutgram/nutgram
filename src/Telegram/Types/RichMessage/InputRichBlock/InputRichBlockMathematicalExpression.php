<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * A block with a mathematical expression in LaTeX format, corresponding to the custom HTML tag <code><tg-math-block></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockmathematicalexpression
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockMathematicalExpression extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “mathematical_expression”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::MATHEMATICAL_EXPRESSION;

    /**
     * The mathematical expression in LaTeX format
     */
    public string $expression;

    public function __construct(string $expression)
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
