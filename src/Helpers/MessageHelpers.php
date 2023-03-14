<?php

namespace SergiX44\Nutgram\Helpers;

use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * @mixin Message
 */
trait MessageHelpers
{
    public function isCommand(): bool
    {
        /** @var MessageEntity $entity */
        $entity = $this->entities[0] ?? null;

        return $entity !== null && $entity->offset === 0 && $entity->type === 'bot_command';
    }

    public function isText(): bool
    {
        return $this->text !== null;
    }

    public function isAnimation(): bool
    {
        return $this->animation !== null;
    }

    public function isAudio(): bool
    {
        return $this->audio !== null;
    }

    public function isDocument(): bool
    {
        return $this->document !== null;
    }

    public function isGame(): bool
    {
        return $this->game !== null;
    }

    public function isPhoto(): bool
    {
        return $this->photo !== null;
    }

    public function isSticker(): bool
    {
        return $this->sticker !== null;
    }

    public function isVideo(): bool
    {
        return $this->video !== null;
    }

    public function isVoice(): bool
    {
        return $this->voice !== null;
    }

    public function isVideoNote(): bool
    {
        return $this->video_note !== null;
    }

    public function isContact(): bool
    {
        return $this->contact !== null;
    }

    public function isLocation(): bool
    {
        return $this->location !== null;
    }

    public function isVenue(): bool
    {
        return $this->venue !== null;
    }

    public function isPoll(): bool
    {
        return $this->poll !== null;
    }

    public function isDice(): bool
    {
        return $this->dice !== null;
    }

    public function isInvoice(): bool
    {
        return $this->invoice !== null;
    }

    public function isPassportData(): bool
    {
        return $this->passport_data !== null;
    }
}
