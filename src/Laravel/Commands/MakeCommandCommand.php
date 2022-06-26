<?php

namespace SergiX44\Nutgram\Laravel\Commands;

class MakeCommandCommand extends BaseMakeCommand
{
    protected $signature = 'nutgram:make:command {name : Command name}';

    protected $description = 'Create a new Nutgram Command';

    /**
     * Return the sub directory name
     * @return string
     */
    protected function getSubDirName():string
    {
        return 'Commands';
    }

    /**
     * Return the stub file path
     * @return string
     */
    protected function getStubPath(): string
    {
        return __DIR__.'/../Stubs/Command.stub';
    }
}
