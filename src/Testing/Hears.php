<?php

namespace SergiX44\Nutgram\Testing;

use InvalidArgumentException;
use ReflectionObject;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * @mixin FakeNutgram
 */
trait Hears
{
    public function setCommonUser(User $user): self
    {
        $this->commonUser = $user;

        return $this;
    }

    public function setCommonChat(Chat $chat): self
    {
        $this->commonChat = $chat;

        return $this;
    }

    /**
     * @param  mixed  $update
     * @return $this
     */
    public function hearUpdate(Update $update): self
    {
        if ($this->commonUser !== null) {
            $update->setUser($this->commonUser);
        }

        if ($this->commonChat !== null) {
            $update->setChat($this->commonChat);
        }

        if ($this->rememberUserAndChat) {
            if ($this->storedUser === null || $this->storedChat === null) {
                $this->storedUser = $update->getUser();
                $this->storedChat = $update->getChat();
            }

            $update->setUser($this->storedUser);
            $update->setChat($this->storedChat);
        }


        $this->getContainer()->get(RunningMode::class)->setUpdate($update);

        return $this;
    }

    /**
     * @param  string  $type
     * @param  array  $partialAttributes
     * @return $this
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
     * @param  array  $value
     * @return $this
     */
    public function hearMessage(array $value): self
    {
        return $this->hearUpdateType(
            UpdateTypes::MESSAGE,
            array_merge(['from' => []], $value)
        );
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function hearText(string $value): self
    {
        return $this->hearMessage(['text' => $value]);
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function hearCallbackQueryData(string $value): self
    {
        return $this->hearUpdateType(UpdateTypes::CALLBACK_QUERY, [
            'message' => ['from' => []],
            'data' => $value,
        ]);
    }
}
