<?php

namespace SergiX44\Nutgram\Laravel\Commands;

class MakeConversationCommand extends BaseMakeCommand
{
    protected $signature = 'nutgram:make:conversation {name : Conversation name} {--menu : Create an inline menu}';

    protected $description = 'Create a new Nutgram Conversation';

    /**
     * Return the sub directory name
     * @return string
     */
    protected function getSubDirName():string
    {
        return 'Conversations';
    }

    /**
     * Return the stub file path
     * @return string
     */
    protected function getStubPath(): string
    {
        if ($this->option('menu')) {
            return __DIR__.'/../Stubs/InlineMenu.stub';
        }

        return __DIR__.'/../Stubs/Conversation.stub';
    }
}
