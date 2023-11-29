<?php


namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SurveyConversation extends Conversation
{
    protected int $surveyID;

    public function start(Nutgram $bot, int $surveyID)
    {
        $this->surveyID = $surveyID;
        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot)
    {
        $bot->set('test', $this->surveyID);
        $this->end();
    }
}
