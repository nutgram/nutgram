<?php

namespace SergiX44\Nutgram\Laravel\Commands;

class MakeMiddlewareCommand extends BaseMakeCommand
{
    protected $signature = 'nutgram:make:middleware {name : Middleware name}';

    protected $description = 'Create a new Nutgram Middleware';

    /**
     * Return the sub directory name
     * @return string
     */
    protected function getSubDirName():string
    {
        return 'Middleware';
    }

    /**
     * Return the stub file path
     * @return string
     */
    protected function getStubPath(): string
    {
        return __DIR__.'/../Stubs/Middleware.stub';
    }
}
