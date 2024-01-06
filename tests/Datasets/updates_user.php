<?php

dataset('updates_user', function () {
    return [
        'message' => [getUpdateType('message'), 'onMessage', true],
        'edited_message' => [getUpdateType('edited_message'), 'onEditedMessage', true],
        'channel_post' => [getUpdateType('channel_post'), 'onChannelPost', false],
        'edited_channel_post' => [getUpdateType('edited_channel_post'), 'onEditedChannelPost', false],
        'message_reaction' => [getUpdateType('message_reaction'), 'onMessageReaction', true],
        'message_reaction_count' => [getUpdateType('message_reaction_count'), 'onMessageReactionCount', false],
        'inline_query' => [getUpdateType('inline_query'), 'onInlineQuery', true],
        'chosen_inline_result' => [getUpdateType('chosen_inline_result'), 'onChosenInlineResult', true],
        'callback_query' => [getUpdateType('callback_query'), 'onCallbackQuery', true],
        'callback_query_without_message' => [getUpdateType('callback_query_without_message'), 'onCallbackQuery', true],
        'shipping_query' => [getUpdateType('shipping_query'), 'onShippingQuery', true],
        'pre_checkout_query' => [getUpdateType('pre_checkout_query'), 'onPreCheckoutQuery', true],
        'poll' => [getUpdateType('poll'), 'onUpdatePoll', false],
        'poll_answer' => [getUpdateType('poll_answer'), 'onPollAnswer', true],
        'my_chat_member' => [getUpdateType('my_chat_member'), 'onMyChatMember', true],
        'chat_member' => [getUpdateType('chat_member'), 'onChatMember', true],
        'chat_join_request' => [getUpdateType('chat_join_request'), 'onChatJoinRequest', true],
        'chat_boost' => [getUpdateType('chat_boost'), 'onChatBoost', true],
        'removed_chat_boost' => [getUpdateType('removed_chat_boost'), 'onRemovedChatBoost', true],
    ];
});
