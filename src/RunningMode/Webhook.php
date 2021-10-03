<?php


namespace SergiX44\Nutgram\RunningMode;

use DI\DependencyException;
use DI\NotFoundException;
use JsonMapper;
use JsonMapper_Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Webhook implements RunningMode
{

    /**
     * @param  Nutgram  $bot
     * @throws DependencyException
     * @throws NotFoundException
     * @throws JsonMapper_Exception
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function processUpdates(Nutgram $bot): void
    {
        $input = file_get_contents('php://input');
        $update = $bot->getContainer()
            ->get(JsonMapper::class)
            ->map(
                json_decode($input, flags: JSON_THROW_ON_ERROR),
                $bot->getContainer()->make(Update::class)
            );
        $bot->processUpdate($update);
    }
}
