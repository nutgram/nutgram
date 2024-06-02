<?php

namespace SergiX44\Nutgram\Testing;

use ReflectionObject;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
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


        $mode = $this->getContainer()->get(RunningMode::class);

        if ($mode instanceof Fake) {
            $mode->setUpdate($update);
        }

        return $this;
    }

    /**
     * @param UpdateType $type
     * @param array $partialAttributes
     * @return $this
     */
    public function hearUpdateType(
        UpdateType $type,
        array $partialAttributes = [],
    ): self {
        $typeName = $type->value;

        /** @var Update $update */
        $update = $this->getContainer()->get(Update::class);

        $class = (new ReflectionObject($update))
            ->getProperty($typeName)
            ->getType()
            ?->getName();

        $update->{$typeName} = $this->typeFaker->fakeInstanceOf($class, $partialAttributes);

        return $this->hearUpdate($update);
    }

    /**
     * @param  array  $value
     * @return $this
     */
    public function hearMessage(array $value): self
    {
        return $this->hearUpdateType(
            UpdateType::MESSAGE,
            ['from' => [], ...$value]
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
        return $this->hearUpdateType(UpdateType::CALLBACK_QUERY, [
            'message' => ['from' => [], 'date' => 1703892479],
            'data' => $value,
        ]);
    }
}
