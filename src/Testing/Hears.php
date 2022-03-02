<?php

namespace SergiX44\Nutgram\Testing;

use InvalidArgumentException;
use ReflectionObject;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

/**
 * @mixin FakeNutgram
 */
trait Hears
{
    /**
     * @param  mixed  $update
     * @return self
     */
    public function hearUpdate(Update $update): self
    {
        $this->getContainer()->get(RunningMode::class)->setUpdate($update);

        return $this;
    }

    /**
     * @param  string  $type
     * @param  array  $partialAttributes
     * @return self
     */
    public function hearUpdateType(string $type, array $partialAttributes = [], bool $fillNullableFields = false): self
    {
        if (!in_array($type, UpdateTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid update type.');
        }

        /** @var Update $update */
        $update = $this->getContainer()->get(Update::class);

        $class = (new ReflectionObject($update))
            ->getProperty($type)
            ->getType()
            ?->getName();

        $update->{$type} = $this->typeFaker->fakeInstanceOf($class, $partialAttributes, $fillNullableFields);

        return $this->hearUpdate($update);
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function hearText(string $value): self
    {
        return $this->hearUpdateType(UpdateTypes::MESSAGE, ['from' => [], 'text' => $value]);
    }
}
