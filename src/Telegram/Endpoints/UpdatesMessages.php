<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Input\InputProfilePhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputStoryContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Media\Story;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Payment\StarAmount;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Sticker\AcceptedGiftTypes;
use SergiX44\Nutgram\Telegram\Types\Sticker\OwnedGifts;
use SergiX44\Nutgram\Telegram\Types\Story\StoryArea;

/**
 * Trait UpdatesMessages
 * @package SergiX44\Nutgram\Telegram
 * @mixin Client
 */
trait UpdatesMessages
{
    /**
     * Use this method to edit text and {@see https://core.telegram.org/bots/api#games game} messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageText(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?LinkPreviewOptions $link_preview_options = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'text',
            'parse_mode',
            'entities',
            'disable_web_page_preview',
            'link_preview_options',
            'reply_markup',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string|null $caption New caption of the message, 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageCaption(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?bool $show_caption_above_media = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'reply_markup',
            'show_caption_above_media',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages, or to add media to text messages.
     * If a message is part of a message album, then it can be edited only to an audio for audio albums, only to a document for document albums and to a photo or a video otherwise.
     * When an inline message is edited, a new file can't be uploaded;
     * use a previously uploaded file via its file_id or specify a URL.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagemedia
     * @param InputMedia $media A JSON-serialized object for a new media content of the message
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param array $clientOpt Client options
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageMedia(
        InputMedia $media,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
        array $clientOpt = [],
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'media',
            'reply_markup',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestMultipart(__FUNCTION__, $parameters, Message::class, $clientOpt);
    }

    /**
     * Use this method to edit live location messages.
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to {@see https://core.telegram.org/bots/api#stopmessagelivelocation stopMessageLiveLocation}telegram.org/bots/api#message Message}LiveLocation.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     * @param float $latitude Latitude of new location
     * @param float $longitude Longitude of new location
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $heading Direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius The maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param int|null $live_period New period in seconds during which the location can be updated, starting from the message send date. If 0x7FFFFFFF is specified, then the location can be updated forever. Otherwise, the new value must not exceed the current live_period by more than a day, and the live location expiration date must remain within the next 90 days. If not specified, then live_period remains unchanged
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageLiveLocation(
        float $latitude,
        float $longitude,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?float $horizontal_accuracy = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?int $live_period = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'latitude',
            'longitude',
            'horizontal_accuracy',
            'heading',
            'proximity_alert_radius',
            'reply_markup',
            'live_period',
            'business_connection_id',
        );

        $this->setChatMessageOrInlineMessageId($parameters);
        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageReplyMarkup(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'reply_markup',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped {@see https://core.telegram.org/bots/api#poll Poll} is returned.
     * @see https://core.telegram.org/bots/api#stoppoll
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the original message with the poll
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new message {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Poll|null
     */
    public function stopPoll(
        int|string $chat_id,
        int $message_id,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): ?Poll {
        $parameters = compact(
            'chat_id',
            'message_id',
            'reply_markup',
            'business_connection_id',
        );

        return $this->requestJson(__FUNCTION__, $parameters, Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:- A message can only be deleted if it was sent less than 48 hours ago.- Service messages about a supergroup, channel, or forum topic creation can't be deleted.- A dice message in a private chat can only be deleted if it was sent more than 24 hours ago.- Bots can delete outgoing messages in private chats, groups, and supergroups.- Bots can delete incoming messages in private chats.- Bots granted can_post_messages permissions can delete outgoing messages in channels.- If the bot is an administrator of a group, it can delete any message there.- If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the message to delete
     * @return bool|null
     */
    public function deleteMessage(int|string $chat_id, int $message_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }

    /**
     * Use this method to delete multiple messages simultaneously.
     * If some of the specified messages can't be found, they are skipped. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int[] $message_ids Identifiers of 1-100 messages to delete. See {@see https://core.telegram.org/bots/api#deletemessage deleteMessage} for limitations on which messages can be deleted
     * @return bool|null
     */
    public function deleteMessages(int|string $chat_id, array $message_ids): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_ids'));
    }

    /**
     * Gifts a Telegram Premium subscription to the given user. Returns True on success.
     * @see https://core.telegram.org/bots/api#giftpremiumsubscription
     * @param int $user_id Unique identifier of the target user who will receive a Telegram Premium subscription
     * @param int $month_count Number of months the Telegram Premium subscription will be active for the user; must be one of 3, 6, or 12
     * @param int $star_count Number of Telegram Stars to pay for the Telegram Premium subscription; must be 1000 for 3 months, 1500 for 6 months, and 2500 for 12 months
     * @param string|null $text Text that will be shown along with the service message about the subscription; 0-128 characters
     * @param ParseMode|string|null $text_parse_mode Mode for parsing entities in the text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param MessageEntity[]|null $text_entities A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @return bool|null
     */
    public function giftPremiumSubscription(
        int $user_id,
        int $month_count,
        int $star_count,
        ?string $text = null,
        ParseMode|string|null $text_parse_mode = null,
        ?array $text_entities = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, compact(
            'user_id',
            'month_count',
            'star_count',
            'text',
            'text_parse_mode',
            'text_entities',
        ));
    }

    /**
     * Marks incoming message as read on behalf of a business account. Requires the can_read_messages business bot right. Returns True on success.
     * @see https://core.telegram.org/bots/api#readbusinessmessage
     * @param int $chat_id Unique identifier of the chat in which the message was received. The chat must have been active in the last 24 hours.
     * @param int $message_id Unique identifier of the message to mark as read
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which to read the message
     * @return bool|null
     */
    public function readBusinessMessage(int $chat_id, int $message_id, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_id',
            'business_connection_id',
        ));
    }

    /**
     * Delete messages on behalf of a business account. Requires the can_delete_outgoing_messages business bot right to delete messages sent by the bot itself, or the can_delete_all_messages business bot right to delete any message. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletebusinessmessages
     * @param array $message_ids A JSON-serialized list of 1-100 identifiers of messages to delete. All messages must be from the same chat. See {@see https://core.telegram.org/bots/api#deletemessage deleteMessage} for limitations on which messages can be deleted
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which to delete the messages
     * @return bool|null
     */
    public function deleteBusinessMessages(array $message_ids, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'message_ids',
            'business_connection_id',
        ));
    }

    /**
     * Changes the first and last name of a managed business account. Requires the can_change_name business bot right. Returns True on success.
     * @see https://core.telegram.org/bots/api#setbusinessaccountname
     * @param string $first_name The new value of the first name for the business account; 1-64 characters
     * @param string $last_name The new value of the last name for the business account; 0-64 characters
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function setBusinessAccountName(string $first_name, string $last_name, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'first_name',
            'last_name',
            'business_connection_id',
        ));
    }

    /**
     * Changes the username of a managed business account. Requires the can_change_username business bot right. Returns True on success.
     * @see https://core.telegram.org/bots/api#setbusinessaccountusername
     * @param string|null $username The new value of the username for the business account; 0-32 characters
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function setBusinessAccountUsername(?string $username = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'username',
            'business_connection_id',
        ));
    }

    /**
     * Changes the bio of a managed business account. Requires the can_change_bio business bot right. Returns True on success.
     * @see https://core.telegram.org/bots/api#setbusinessaccountbio
     * @param string|null $bio The new value of the bio for the business account; 0-140 characters
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function setBusinessAccountBio(?string $bio = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'bio',
            'business_connection_id',
        ));
    }

    /**
     * Changes the profile photo of a managed business account.
     * Requires the can_edit_profile_photo business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setbusinessaccountprofilephoto
     * @param InputProfilePhoto $photo The new profile photo to set
     * @param bool|null $is_public Pass True to set the public photo, which will be visible even if the main photo is hidden by the business account's privacy settings. An account can have only one public photo.
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function setBusinessAccountProfilePhoto(InputProfilePhoto $photo, ?bool $is_public = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestMultipart(__FUNCTION__, compact(
            'photo',
            'is_public',
            'business_connection_id',
        ));
    }

    /**
     * Removes the current profile photo of a managed business account.
     * Requires the can_edit_profile_photo business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#removebusinessaccountprofilephoto
     * @param bool|null $is_public Pass True to remove the public photo, which is visible even if the main photo is hidden by the business account's privacy settings. After the main photo is removed, the previous profile photo (if present) becomes the main photo.
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function removeBusinessAccountProfilePhoto(?bool $is_public = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'is_public',
            'business_connection_id',
        ));
    }

    /**
     * Changes the privacy settings pertaining to incoming gifts in a managed business account.
     * Requires the can_change_gift_settings business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setbusinessaccountgiftsettings
     * @param bool $show_gift_button Pass True, if a button for sending a gift to the user or by the business account must always be shown in the input field
     * @param AcceptedGiftTypes $accepted_gift_types Types of gifts accepted by the business account
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function setBusinessAccountGiftSettings(bool $show_gift_button, AcceptedGiftTypes $accepted_gift_types, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'show_gift_button',
            'accepted_gift_types',
            'business_connection_id',
        ));
    }

    /**
     * Returns the amount of Telegram Stars owned by a managed business account. Requires the can_view_gifts_and_stars business bot right.
     * Returns {@see https://core.telegram.org/bots/api#staramount StarAmount} on success.
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return StarAmount|null
     */
    public function getBusinessAccountStarBalance(?string $business_connection_id = null): ?StarAmount
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'business_connection_id',
        ), StarAmount::class);
    }

    /**
     * Transfers Telegram Stars from the business account balance to the bot's balance.
     * Requires the can_transfer_stars business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#transferbusinessaccountstars
     * @param int $star_count Number of Telegram Stars to transfer; 1-10000
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function transferBusinessAccountStars(int $star_count, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'star_count',
            'business_connection_id',
        ));
    }

    /**
     * Returns the gifts received and owned by a managed business account.
     * Requires the can_view_gifts_and_stars business bot right.
     * Returns OwnedGifts on success.
     * @see https://core.telegram.org/bots/api#getbusinessaccountgifts
     * @param bool|null $exclude_unsaved Pass True to exclude gifts that aren't saved to the account's profile page
     * @param bool|null $exclude_saved Pass True to exclude gifts that are saved to the account's profile page
     * @param bool|null $exclude_unlimited Pass True to exclude gifts that can be purchased an unlimited number of times
     * @param bool|null $exclude_limited Pass True to exclude gifts that can be purchased a limited number of times
     * @param bool|null $exclude_unique Pass True to exclude unique gifts
     * @param bool|null $sort_by_price Pass True to sort results by gift price instead of send date. Sorting is applied before pagination.
     * @param bool|null $offset Offset of the first entry to return as received from the previous request; use empty string to get the first chunk of results
     * @param bool|null $limit The maximum number of gifts to be returned; 1-100. Defaults to 100
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return OwnedGifts|null
     */
    public function getBusinessAccountGifts(
        ?bool $exclude_unsaved = null,
        ?bool $exclude_saved = null,
        ?bool $exclude_unlimited = null,
        ?bool $exclude_limited = null,
        ?bool $exclude_unique = null,
        ?bool $sort_by_price = null,
        ?bool $offset = null,
        ?bool $limit = null,
        ?string $business_connection_id = null,
    ): ?OwnedGifts {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'exclude_unsaved',
            'exclude_saved',
            'exclude_unlimited',
            'exclude_limited',
            'exclude_unique',
            'sort_by_price',
            'offset',
            'limit',
            'business_connection_id',
        ));
    }

    /**
     * Converts a given regular gift to Telegram Stars.
     * Requires the can_convert_gifts_to_stars business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#convertgifttostars
     * @param string $owned_gift_id Unique identifier of the regular gift that should be converted to Telegram Stars
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function convertGiftToStars(string $owned_gift_id, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'owned_gift_id',
            'business_connection_id',
        ));
    }

    /**
     * Upgrades a given regular gift to a unique gift.
     * Requires the can_transfer_and_upgrade_gifts business bot right.
     * Additionally requires the can_transfer_stars business bot right if the upgrade is paid.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#upgradegift
     * @param string $owned_gift_id Unique identifier of the regular gift that should be upgraded to a unique one
     * @param bool|null $keep_original_details Pass True to keep the original gift text, sender and receiver in the upgraded gift
     * @param bool|null $star_count The amount of Telegram Stars that will be paid for the upgrade from the business account balance. If gift.prepaid_upgrade_star_count > 0, then pass 0, otherwise, the can_transfer_stars business bot right is required and gift.upgrade_star_count must be passed.
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function upgradeGift(string $owned_gift_id, ?bool $keep_original_details = null, ?bool $star_count = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'owned_gift_id',
            'keep_original_details',
            'star_count',
            'business_connection_id',
        ));
    }

    /**
     * Transfers an owned unique gift to another user.
     * Requires the can_transfer_and_upgrade_gifts business bot right.
     * Requires can_transfer_stars business bot right if the transfer is paid.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#transfergift
     * @param string $owned_gift_id Unique identifier of the regular gift that should be transferred
     * @param int $new_owner_chat_id Unique identifier of the chat which will own the gift. The chat must be active in the last 24 hours.
     * @param int|null $star_count The amount of Telegram Stars that will be paid for the transfer from the business account balance. If positive, then the can_transfer_stars business bot right is required.
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function transferGift(string $owned_gift_id, int $new_owner_chat_id, ?int $star_count = null, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'owned_gift_id',
            'new_owner_chat_id',
            'star_count',
            'business_connection_id',
        ));
    }

    /**
     * Posts a story on behalf of a managed business account.
     * Requires the can_manage_stories business bot right.
     * Returns {@see https://core.telegram.org/bots/api#story Story} on success.
     * @see https://core.telegram.org/bots/api#poststory
     * @param InputStoryContent $content Content of the story
     * @param int $active_period Period after which the story is moved to the archive, in seconds; must be one of 6 * 3600, 12 * 3600, 86400, or 2 * 86400
     * @param string|null $caption Caption of the story, 0-2048 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the story caption. See formatting options for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param StoryArea[]|null $areas A JSON-serialized list of clickable areas to be shown on the story
     * @param bool|null $post_to_chat_page Pass True to keep the story accessible after it expires
     * @param bool|null $protect_content Pass True if the content of the story must be protected from forwarding and screenshotting
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return Story|null
     */
    public function postStory(
        InputStoryContent $content,
        int $active_period,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?array $areas = null,
        ?bool $post_to_chat_page = null,
        ?bool $protect_content = null,
        ?string $business_connection_id = null,
    ): ?Story {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestMultipart(__FUNCTION__, compact(
            'content',
            'active_period',
            'caption',
            'parse_mode',
            'caption_entities',
            'areas',
            'post_to_chat_page',
            'protect_content',
            'business_connection_id',
        ), Story::class);
    }

    /**
     * Edits a story previously posted by the bot on behalf of a managed business account.
     * Requires the can_manage_stories business bot right.
     * Returns {@see https://core.telegram.org/bots/api#story Story} on success.
     * @see https://core.telegram.org/bots/api#editstory
     * @param int $story_id Unique identifier of the story to edit
     * @param InputStoryContent $content Content of the story
     * @param string|null $caption Caption of the story, 0-2048 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the story caption. See formatting options for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param StoryArea[]|null $areas A JSON-serialized list of clickable areas to be shown on the story
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return Story|null
     */
    public function editStory(
        int $story_id,
        InputStoryContent $content,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?array $areas = null,
        ?string $business_connection_id = null,
    ): ?Story {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestMultipart(__FUNCTION__, compact(
            'story_id',
            'content',
            'caption',
            'parse_mode',
            'caption_entities',
            'areas',
            'business_connection_id',
        ), Story::class);
    }

    /**
     * Deletes a story previously posted by the bot on behalf of a managed business account.
     * Requires the can_manage_stories business bot right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestory
     * @param int $story_id Unique identifier of the story to delete
     * @param string|null $business_connection_id Unique identifier of the business connection
     * @return bool|null
     */
    public function deleteStory(int $story_id, ?string $business_connection_id = null): ?bool
    {
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'story_id',
            'business_connection_id',
        ));
    }
}
