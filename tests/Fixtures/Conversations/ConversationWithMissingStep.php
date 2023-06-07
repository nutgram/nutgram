<?php


namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;

class ConversationWithMissingStep extends Conversation
{
    protected ?string $step = 'missing';
}
