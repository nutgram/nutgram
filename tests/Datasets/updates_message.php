<?php

dataset('updates_message', function () {
    return [
        'message' => [getUpdateType('message'), 'onMessage', true],
        'edited_message' => [getUpdateType('edited_message'), 'onEditedMessage', true],
        'channel_post' => [getUpdateType('channel_post'), 'onChannelPost', true],
        'edited_channel_post' => [getUpdateType('edited_channel_post'), 'onEditedChannelPost', true],
        'inline_query' => [getUpdateType('inline_query'), 'onInlineQuery', false],
        'chosen_inline_result' => [getUpdateType('chosen_inline_result'), 'onChosenInlineResult', false],
        'callback_query' => [getUpdateType('callback_query'), 'onCallbackQuery', true],
        'callback_query_without_message' => [getUpdateType('callback_query_without_message'), 'onCallbackQuery', false],
        'shipping_query' => [getUpdateType('shipping_query'), 'onShippingQuery', false],
        'pre_checkout_query' => [getUpdateType('pre_checkout_query'), 'onPreCheckoutQuery', false],
        'poll' => [getUpdateType('poll'), 'onPoll', false],
        'poll_answer' => [getUpdateType('poll_answer'), 'onPollAnswer', false],
        'my_chat_member' => [getUpdateType('my_chat_member'), 'onMyChatMember', false],
        'chat_member' => [getUpdateType('chat_member'), 'onChatMember', false],
        'chat_join_request' => [getUpdateType('chat_join_request'), 'onChatJoinRequest', false],
    ];
});
