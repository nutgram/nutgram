<?php

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourceResolver;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatAdministratorRights;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatFullInfo;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberResolver;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatPermissions;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllPrivateChats;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChat;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatAdministrators;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatMember;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeResolver;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonResolver;
use SergiX44\Nutgram\Telegram\Types\Common\LoginUrl;
use SergiX44\Nutgram\Telegram\Types\Game\CallbackGame;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultArticle;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultAudio;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedAudio;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedDocument;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedGif;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedMpeg4Gif;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedPhoto;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedSticker;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedVideo;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultCachedVoice;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultContact;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultDocument;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultGame;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultGif;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultLocation;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultMpeg4Gif;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultPhoto;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultsButton;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultVenue;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultVideo;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResultVoice;
use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputInvoiceMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAnimation;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAudio;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaDocument;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Input\InputPaidMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputPaidMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Input\InputSticker;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\CopyTextButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButtonPollType;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButtonRequestChat;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButtonRequestUsers;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Keyboard\SwitchInlineQueryChosenChat;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillResolver;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypeResolver;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginResolver;
use SergiX44\Nutgram\Telegram\Types\Message\ReplyParameters;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorDataField;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorFile;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorFiles;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorFrontSide;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorReverseSide;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorSelfie;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorTranslationFile;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorTranslationFiles;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementErrorUnspecified;
use SergiX44\Nutgram\Telegram\Types\Payment\LabeledPrice;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaResolver;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalStateResolver;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingOption;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerResolver;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeCustomEmoji;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeEmoji;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeResolver;
use SergiX44\Nutgram\Telegram\Types\Sticker\MaskPosition;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

arch('check that the code is using strict types')
    ->expect('SergiX44\Nutgram')
    ->toUseStrictTypes();

arch('check that Telegram types extends BaseType')
    ->expect('SergiX44\Nutgram\Telegram\Types')
    ->classes()
    ->toExtend(BaseType::class)
    ->ignoring([
        'SergiX44\Nutgram\Telegram\Types\Internal',
        ChatBoostSourceResolver::class,
        ChatMemberResolver::class,
        BotCommandScopeResolver::class,
        MenuButtonResolver::class,
        BackgroundFillResolver::class,
        BackgroundTypeResolver::class,
        MessageOriginResolver::class,
        PaidMediaResolver::class,
        RevenueWithdrawalStateResolver::class,
        TransactionPartnerResolver::class,
        ReactionTypeResolver::class,
    ]);

arch('check that Telegram types with static make method does not have constructor')
    ->expect([
        BotCommand::class,
        BotCommandScopeAllPrivateChats::class,
        BotCommandScopeChat::class,
        BotCommandScopeChatAdministrators::class,
        BotCommandScopeChatMember::class,
        CallbackGame::class,
        Chat::class,
        ChatAdministratorRights::class,
        ChatFullInfo::class,
        ChatPermissions::class,
        CopyTextButton::class,
        ForceReply::class,
        InlineKeyboardButton::class,
        InlineKeyboardMarkup::class,
        InlineQueryResultArticle::class,
        InlineQueryResultAudio::class,
        InlineQueryResultCachedAudio::class,
        InlineQueryResultCachedDocument::class,
        InlineQueryResultCachedGif::class,
        InlineQueryResultCachedMpeg4Gif::class,
        InlineQueryResultCachedPhoto::class,
        InlineQueryResultCachedSticker::class,
        InlineQueryResultCachedVideo::class,
        InlineQueryResultCachedVoice::class,
        InlineQueryResultContact::class,
        InlineQueryResultDocument::class,
        InlineQueryResultGame::class,
        InlineQueryResultGif::class,
        InlineQueryResultLocation::class,
        InlineQueryResultMpeg4Gif::class,
        InlineQueryResultPhoto::class,
        InlineQueryResultsButton::class,
        InlineQueryResultVenue::class,
        InlineQueryResultVideo::class,
        InlineQueryResultVoice::class,
        InputContactMessageContent::class,
        InputInvoiceMessageContent::class,
        InputLocationMessageContent::class,
        InputMediaAnimation::class,
        InputMediaAudio::class,
        InputMediaDocument::class,
        InputMediaPhoto::class,
        InputMediaVideo::class,
        InputPaidMediaPhoto::class,
        InputPaidMediaVideo::class,
        InputSticker::class,
        InputTextMessageContent::class,
        InputVenueMessageContent::class,
        KeyboardButton::class,
        KeyboardButtonPollType::class,
        KeyboardButtonRequestChat::class,
        KeyboardButtonRequestUsers::class,
        LabeledPrice::class,
        LinkPreviewOptions::class,
        LoginUrl::class,
        MaskPosition::class,
        MessageEntity::class,
        PassportElementErrorDataField::class,
        PassportElementErrorFile::class,
        PassportElementErrorFiles::class,
        PassportElementErrorFrontSide::class,
        PassportElementErrorReverseSide::class,
        PassportElementErrorSelfie::class,
        PassportElementErrorTranslationFile::class,
        PassportElementErrorTranslationFiles::class,
        PassportElementErrorUnspecified::class,
        ReactionTypeCustomEmoji::class,
        ReactionTypeEmoji::class,
        ReplyKeyboardMarkup::class,
        ReplyKeyboardRemove::class,
        ReplyParameters::class,
        ShippingOption::class,
        SwitchInlineQueryChosenChat::class,
        User::class,
        WebAppInfo::class,
    ])
    ->not->toHaveConstructor();
