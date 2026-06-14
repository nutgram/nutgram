<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

/**
 * This object represents a rich formatted text.
 * Currently, it can be either a String for plain text, an Array of RichText, or any of the following types:
 * {@see RichTextBold}
 * {@see RichTextItalic}
 * {@see RichTextUnderline}
 * {@see RichTextStrikethrough}
 * {@see RichTextSpoiler}
 * {@see RichTextDateTime}
 * {@see RichTextTextMention}
 * {@see RichTextSubscript}
 * {@see RichTextSuperscript}
 * {@see RichTextMarked}
 * {@see RichTextCode}
 * {@see RichTextCustomEmoji}
 * {@see RichTextMathematicalExpression}
 * {@see RichTextUrl}
 * {@see RichTextEmailAddress}
 * {@see RichTextPhoneNumber}
 * {@see RichTextBankCardNumber}
 * {@see RichTextMention}
 * {@see RichTextHashtag}
 * {@see RichTextCashtag}
 * {@see RichTextBotCommand}
 * {@see RichTextAnchor}
 * {@see RichTextAnchorLink}
 * {@see RichTextReference}
 * {@see RichTextReferenceLink}
 * @see https://core.telegram.org/bots/api#richtext
 */
#[RichTextResolver]
interface RichText
{
    // nothing here, this interface is only for type hinting
}
