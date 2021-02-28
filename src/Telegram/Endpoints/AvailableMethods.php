<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Chat;
use SergiX44\Nutgram\Telegram\Types\ChatMember;
use SergiX44\Nutgram\Telegram\Types\ChatPermissions;
use SergiX44\Nutgram\Telegram\Types\File;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\MessageId;
use SergiX44\Nutgram\Telegram\Types\User;
use SergiX44\Nutgram\Telegram\Types\UserProfilePhotos;

/**
 * Trait AvailableMethods
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait AvailableMethods
{
    /**
     * @return User|null
     */
    public function getMe(): ?User
    {
        return $this->requestJson(__FUNCTION__, mapTo: User::class);
    }

    /**
     * @return bool|null
     */
    public function logOut(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * @return bool|null
     */
    public function close(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * @param  string  $text
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendMessage(string $text, ?array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('text', 'chat_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  string|int  $from_chat_id
     * @param  int  $message_id
     * @param  array  $opt
     * @return Message|null
     */
    public function forwardMessage(string|int $chat_id, string|int $from_chat_id, int $message_id, array $opt = []): ?Message
    {
        $required = compact('chat_id', 'from_chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  string|int  $from_chat_id
     * @param  int  $message_id
     * @param  array  $opt
     * @return MessageId|null
     */
    public function copyMessage(string|int $chat_id, string|int $from_chat_id, int $message_id, array $opt = []): ?MessageId
    {
        $required = compact('chat_id', 'from_chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), MessageId::class);
    }

    /**
     * @param $photo
     * @param  array  $opt
     * @return Message|null
     */
    public function sendPhoto($photo, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'photo', $photo, $opt);
    }

    /**
     * @param $audio
     * @param  array  $opt
     * @return Message|null
     */
    public function sendAudio($audio, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'audio', $audio, $opt);
    }

    /**
     * @param $document
     * @param  array  $opt
     * @return Message|null
     */
    public function sendDocument($document, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'document', $document, $opt);
    }

    /**
     * @param $video
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVideo($video, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'video', $video, $opt);
    }

    /**
     * @param $animation
     * @param  array  $opt
     * @return Message|null
     */
    public function sendAnimation($animation, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'animation', $animation, $opt);
    }


    /**
     * @param $voice
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVoice($voice, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'voice', $voice, $opt);
    }

    /**
     * @param $video_note
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVideoNote($video_note, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'video_note', $video_note, $opt);
    }

    /**
     * @param  array  $media
     * @param  array  $opt
     * @return array|null
     */
    public function sendMediaGroup(array $media, array $opt = []): ?array
    {
        $required = [
            'chat_id' => $this->chatId(),
            'media' => json_encode($media),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendLocation(float $latitude, float $longitude, ?array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('latitude', 'longitude', 'chat_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  array|null  $opt
     * @return Message|bool|null
     */
    public function editMessageLiveLocation(float $latitude, float $longitude, ?array $opt = []): Message|bool|null
    {
        $required = compact('latitude', 'longitude');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  array|null  $opt
     * @return Message|bool|null
     */
    public function stopMessageLiveLocation(?array $opt = []): Message|bool|null
    {
        return $this->requestJson(__FUNCTION__, $opt, Message::class);
    }

    /**
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  string  $title
     * @param  string  $address
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendVenue(float $latitude, float $longitude, string $title, string $address, ?array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('latitude', 'longitude', 'chat_id', 'title', 'address');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string  $first_name
     * @param  string  $phone_number
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendContact(string $first_name, string $phone_number, ?array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('chat_id', 'first_name', 'phone_number');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string  $question
     * @param  array  $options
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendPoll(string $question, array $options, ?array $opt = []): ?Message
    {
        $required = [
            'chat_id' => $this->chatId(),
            'question' => $question,
            'options' => json_encode($options),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendDice(?array $opt = []): ?Message
    {
        $chat_id = $this->chatId();
        $required = compact('chat_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string  $action
     * @param  array|null  $opt
     * @return bool|null
     */
    public function sendChatAction(string $action, ?array $opt = []): ?bool
    {
        $chat_id = $this->chatId();
        $required = compact('chat_id', 'action');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  array|null  $opt
     * @return UserProfilePhotos|null
     */
    public function getUserProfilePhotos(?array $opt = []): ?UserProfilePhotos
    {
        $user_id = $this->userId();
        $required = compact('user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), UserProfilePhotos::class);
    }

    /**
     * @param  string  $file_id
     * @return File|null
     */
    public function getFile(string $file_id): ?File
    {
        return $this->requestJson(__FUNCTION__, compact('file_id'), File::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @param  array|null  $opt
     * @return bool|null
     */
    public function kickChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @param  array|null  $opt
     * @return bool|null
     */
    public function unbanChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @param  ChatPermissions  $permissions
     * @param  array|null  $opt
     * @return bool|null
     */
    public function restrictChatMember(string|int $chat_id, int $user_id, ChatPermissions $permissions, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        $required['permissions'] = json_encode($permissions);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @param  array|null  $opt
     * @return bool|null
     */
    public function promoteChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @param  string  $custom_title
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setChatAdministratorCustomTitle(string|int $chat_id, int $user_id, string $custom_title, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id', 'custom_title');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  ChatPermissions  $permissions
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setChatPermissions(string|int $chat_id, ChatPermissions $permissions, ?array $opt = []): ?bool
    {
        $required = compact('chat_id');
        $required['permissions'] = json_encode($permissions);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @return string|null
     */
    public function exportChatInviteLink(string|int $chat_id): ?string
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @param $photo
     * @return bool|null
     */
    public function setChatPhoto(string|int $chat_id, $photo): ?bool
    {
        return $this->requestMultipart(__FUNCTION__, compact('chat_id', 'photo'));
    }

    /**
     * @param  string|int  $chat_id
     * @return bool|null
     */
    public function deleteChatPhoto(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @param  string  $title
     * @return bool|null
     */
    public function setChatTitle(string|int $chat_id, string $title): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'title'));
    }

    /**
     * @param  string|int  $chat_id
     * @param  string|null  $description
     * @return bool|null
     */
    public function setChatDescription(string|int $chat_id, ?string $description = null): ?bool
    {
        $parameters = compact('chat_id');
        if ($description !== null) {
            $parameters['description'] = $description;
        }
        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $message_id
     * @param  array|null  $opt
     * @return bool|null
     */
    public function pinChatMessage(string|int $chat_id, int $message_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $message_id
     * @return bool|null
     */
    public function unpinChatMessage(string|int $chat_id, int $message_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @return bool|null
     */
    public function unpinAllChatMessages(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @return bool|null
     */
    public function leaveChat(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @return Chat|null
     */
    public function getChat(string|int $chat_id): ?Chat
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), Chat::class);
    }

    /**
     * @param  string|int  $chat_id
     * @return array|null
     */
    public function getChatAdministrators(string|int $chat_id): ?array
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), ChatMember::class);
    }

    /**
     * @param  string|int  $chat_id
     * @return int|null
     */
    public function getChatMembersCount(string|int $chat_id): ?int
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $user_id
     * @return ChatMember|null
     */
    public function getChatMember(string|int $chat_id, int $user_id): ?ChatMember
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'), ChatMember::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  string  $sticker_set_name
     * @return bool|null
     */
    public function setChatStickerSet(string|int $chat_id, string $sticker_set_name): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'sticker_set_name'));
    }

    /**
     * @param  string|int  $chat_id
     * @return bool|null
     */
    public function deleteChatStickerSet(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * @param  array|null  $opt
     * @return bool|null
     */
    public function answerCallbackQuery(?array $opt = []): ?bool
    {
        $required = ['callback_query_id' => $this->callbackQuery()?->id];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  array  $commands
     * @return bool|null
     */
    public function setMyCommands(array $commands = []): ?bool
    {
        return $this->requestJson(__FUNCTION__, ['commands' => json_encode($commands)]);
    }

    /**
     * @return array|null
     */
    public function getMyCommands(): ?array
    {
        return $this->requestJson(__FUNCTION__, mapTo: BotCommand::class);
    }
}