<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;

#[Attribute(Attribute::TARGET_CLASS)]
class InputMessageContentResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        // This object type is never returned by the API, only sent by the user.
        return InputTextMessageContent::class;
    }
}
