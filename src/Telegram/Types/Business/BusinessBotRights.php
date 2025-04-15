<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the rights of a business bot.
 * @see https://core.telegram.org/bots/api#businessbotrights
 */
class BusinessBotRights extends BaseType implements JsonSerializable
{
    /**
     * Optional. True, if the bot can send and edit messages in the private chats that had incoming messages in the last 24 hours
     */
    public ?bool $can_reply = null;

    /**
     * Optional. True, if the bot can mark incoming private messages as read
     */
    public ?bool $can_read_messages = null;

    /**
     * Optional. True, if the bot can delete messages sent by the bot
     */
    public ?bool $can_delete_outgoing_messages = null;

    /**
     * Optional. True, if the bot can delete all private messages in managed chats
     */
    public ?bool $can_delete_all_messages = null;

    /**
     * Optional. True, if the bot can edit the first and last name of the business account
     */
    public ?bool $can_edit_name = null;

    /**
     * Optional. True, if the bot can edit the bio of the business account
     */
    public ?bool $can_edit_bio = null;

    /**
     * Optional. True, if the bot can edit the profile photo of the business account
     */
    public ?bool $can_edit_profile_photo = null;

    /**
     * Optional. True, if the bot can edit the username of the business account
     */
    public ?bool $can_edit_username = null;

    /**
     * Optional. True, if the bot can change the privacy settings pertaining to gifts for the business account
     */
    public ?bool $can_change_gift_settings = null;

    /**
     * Optional. True, if the bot can view gifts and the amount of Telegram Stars owned by the business account
     */
    public ?bool $can_view_gifts_and_stars = null;

    /**
     * Optional. True, if the bot can convert regular gifts owned by the business account to Telegram Stars
     */
    public ?bool $can_convert_gifts_to_stars = null;

    /**
     * Optional. True, if the bot can transfer and upgrade gifts owned by the business account
     */
    public ?bool $can_transfer_and_upgrade_gifts = null;

    /**
     * Optional. True, if the bot can transfer Telegram Stars received by the business account to its own account, or use them to upgrade and transfer gifts
     */
    public ?bool $can_transfer_stars = null;

    /**
     * Optional. True, if the bot can post, edit and delete stories on behalf of the business account
     */
    public ?bool $can_manage_stories = null;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
