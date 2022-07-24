<?php

namespace SergiX44\Nutgram\Laravel\Commands;

class MakeHandlerCommand extends BaseMakeCommand
{
    protected $signature = 'nutgram:make:handler {name : Handler name}';

    protected $description = 'Create a new Nutgram Handler';

    /**
     * Return the sub directory name
     * @return string
     */
    protected function getSubDirName():string
    {
        return 'Handlers';
    }

    /**
     * Return the stub file path
     * @return string
     */
    protected function getStubPath(): string
    {
        return __DIR__.'/../Stubs/Handler.stub';
    }
}
