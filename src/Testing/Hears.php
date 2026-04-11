<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use ReflectionObject;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\User\User;
use function SergiX44\Nutgram\Support\getSafeReflectionTypeName;

/**
 * @mixin FakeNutgram
 */
trait Hears
{
    public function setCommonUser(User $user): static
    {
        $this->commonUser = $user;

        return $this;
    }

    public function setCommonChat(Chat $chat): static
    {
        $this->commonChat = $chat;

        return $this;
    }

    /**
     * @param Update $update
     * @return static
     */
    public function hearUpdate(Update $update): static
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
     * @return static
     */
    public function hearUpdateType(
        UpdateType $type,
        array $partialAttributes = [],
    ): static {
        $typeName = $type->value;

        /** @var Update $update */
        $update = $this->getContainer()->get(Update::class);

        $reflectionType = (new ReflectionObject($update))->getProperty($typeName)->getType();

        $class = getSafeReflectionTypeName($reflectionType);

        $update->{$typeName} = $this->typeFaker->fakeInstanceOf($class, $partialAttributes);

        return $this->hearUpdate($update);
    }

    /**
     * @param  array  $value
     * @return static
     */
    public function hearMessage(array $value): static
    {
        return $this->hearUpdateType(
            UpdateType::MESSAGE,
            ['from' => [], ...$value]
        );
    }

    /**
     * @param  string  $value
     * @return static
     */
    public function hearText(string $value): static
    {
        return $this->hearMessage(['text' => $value]);
    }

    /**
     * @param  string  $value
     * @return static
     */
    public function hearCallbackQueryData(string $value): static
    {
        return $this->hearUpdateType(UpdateType::CALLBACK_QUERY, [
            'message' => ['from' => [], 'date' => 1703892479],
            'data' => $value,
        ]);
    }
}
