<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A mathematical expression.
 * @see https://core.telegram.org/bots/api#richtextmathematicalexpression
 */
class RichTextMathematicalExpression extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “mathematical_expression”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::MATHEMATICAL_EXPRESSION;

    /**
     * The expression in LaTeX format
     */
    public string $expression;
}
