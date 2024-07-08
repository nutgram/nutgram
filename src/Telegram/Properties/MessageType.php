<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum MessageType: string
{
    case TEXT = 'text';
    case ANIMATION = 'animation';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case PHOTO = 'photo';
    case STICKER = 'sticker';
    case VIDEO = 'video';
    case VIDEO_NOTE = 'video_note';
    case VOICE = 'voice';
    case CONTACT = 'contact';
    case DICE = 'dice';
    case GAME = 'game';
    case POLL = 'poll';
    case VENUE = 'venue';
    case LOCATION = 'location';
    case STORY = 'story';
    case NEW_CHAT_MEMBERS = 'new_chat_members';
    case LEFT_CHAT_MEMBER = 'left_chat_member';
    case NEW_CHAT_TITLE = 'new_chat_title';
    case NEW_CHAT_PHOTO = 'new_chat_photo';
    case DELETE_CHAT_PHOTO = 'delete_chat_photo';
    case GROUP_CHAT_CREATED = 'group_chat_created';
    case SUPERGROUP_CHAT_CREATED = 'supergroup_chat_created';
    case CHANNEL_CHAT_CREATED = 'channel_chat_created';
    case MESSAGE_AUTO_DELETE_TIMER_CHANGED = 'message_auto_delete_timer_changed';
    case MIGRATE_TO_CHAT_ID = 'migrate_to_chat_id';
    case MIGRATE_FROM_CHAT_ID = 'migrate_from_chat_id';
    case PINNED_MESSAGE = 'pinned_message';
    case INVOICE = 'invoice';
    case SUCCESSFUL_PAYMENT = 'successful_payment';
    case REFUNDED_PAYMENT = 'refunded_payment';
    case USERS_SHARED = 'users_shared';
    case CHAT_SHARED = 'chat_shared';
    case CONNECTED_WEBSITE = 'connected_website';
    case PASSPORT_DATA = 'passport_data';
    case PROXIMITY_ALERT_TRIGGERED = 'proximity_alert_triggered';
    case BOOST_ADDED = 'boost_added';
    case FORUM_TOPIC_CREATED = 'forum_topic_created';
    case FORUM_TOPIC_EDITED = 'forum_topic_edited';
    case FORUM_TOPIC_CLOSED = 'forum_topic_closed';
    case FORUM_TOPIC_REOPENED = 'forum_topic_reopened';
    case GIVEAWAY_CREATED = 'giveaway_created';
    case GIVEAWAY = 'giveaway';
    case GIVEAWAY_WINNERS = 'giveaway_winners';
    case GIVEAWAY_COMPLETED = 'giveaway_completed';
    case VIDEO_CHAT_SCHEDULED = 'video_chat_scheduled';
    case VIDEO_CHAT_STARTED = 'video_chat_started';
    case VIDEO_CHAT_ENDED = 'video_chat_ended';
    case VIDEO_CHAT_PARTICIPANTS_INVITED = 'video_chat_participants_invited';
    case WEB_APP_DATA = 'web_app_data';
}
