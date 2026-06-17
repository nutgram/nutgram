<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextAnchor;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextAnchorLink;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextBankCardNumber;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextBold;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextBotCommand;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextCashtag;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextCode;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextCustomEmoji;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextDateTime;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextEmailAddress;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextHashtag;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextItalic;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextMarked;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextMathematicalExpression;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextMention;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextPhoneNumber;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextReference;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextReferenceLink;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextSpoiler;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextStrikethrough;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextSubscript;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextSuperscript;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextTextMention;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnderline;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUrl;

#[Attribute(Attribute::TARGET_CLASS)]
class RichTextResolver extends ConcreteResolver
{
    protected array $concretes = [
        RichTextType::BOLD->value => RichTextBold::class,
        RichTextType::ITALIC->value => RichTextItalic::class,
        RichTextType::UNDERLINE->value => RichTextUnderline::class,
        RichTextType::STRIKETHROUGH->value => RichTextStrikethrough::class,
        RichTextType::SPOILER->value => RichTextSpoiler::class,
        RichTextType::DATETIME->value => RichTextDateTime::class,
        RichTextType::TEXT_MENTION->value => RichTextTextMention::class,
        RichTextType::SUBSCRIPT->value => RichTextSubscript::class,
        RichTextType::SUPERSCRIPT->value => RichTextSuperscript::class,
        RichTextType::MARKED->value => RichTextMarked::class,
        RichTextType::CODE->value => RichTextCode::class,
        RichTextType::CUSTOM_EMOJI->value => RichTextCustomEmoji::class,
        RichTextType::MATHEMATICAL_EXPRESSION->value => RichTextMathematicalExpression::class,
        RichTextType::URL->value => RichTextUrl::class,
        RichTextType::EMAIL_ADDRESS->value => RichTextEmailAddress::class,
        RichTextType::PHONE_NUMBER->value => RichTextPhoneNumber::class,
        RichTextType::BANK_CARD_NUMBER->value => RichTextBankCardNumber::class,
        RichTextType::MENTION->value => RichTextMention::class,
        RichTextType::HASHTAG->value => RichTextHashtag::class,
        RichTextType::CASHTAG->value => RichTextCashtag::class,
        RichTextType::BOT_COMMAND->value => RichTextBotCommand::class,
        RichTextType::ANCHOR->value => RichTextAnchor::class,
        RichTextType::ANCHOR_LINK->value => RichTextAnchorLink::class,
        RichTextType::REFERENCE->value => RichTextReference::class,
        RichTextType::REFERENCE_LINK->value => RichTextReferenceLink::class,
    ];
    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class implements RichText {
        })::class;
    }
}
