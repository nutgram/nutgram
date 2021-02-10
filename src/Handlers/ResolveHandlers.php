<?php


namespace SergiX44\Nutgram\Handlers;


use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait ResolveHandlers
 * @package SergiX44\Nutgram\Handlers
 */
abstract class ResolveHandlers extends HandlersChain
{

    public function processUpdate(Update $update)
    {

    }

}