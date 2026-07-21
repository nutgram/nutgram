<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A bot command.
 * @see https://core.telegram.org/bots/api#richtextbotcommand
 */
class RichTextBotCommand extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “bot_command”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::BOT_COMMAND;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * The bot command
     */
    public string $bot_command;
}
