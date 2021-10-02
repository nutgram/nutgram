<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use JsonException;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatInviteLink;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMember;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatPermissions;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageId;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\User\UserProfilePhotos;

/**
 * Trait AvailableMethods
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait AvailableMethods
{
    /**
     * A simple method for testing your bot's auth token.
     * Requires no parameters.
     * Returns basic information about the bot in form of a {@see https://core.telegram.org/bots/api#user User} object.
     * @see https://core.telegram.org/bots/api#getme
     * @return User|null
     */
    public function getMe(): ?User
    {
        return $this->requestJson(__FUNCTION__, mapTo: User::class);
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     * You must log out the bot before running it locally,
     * otherwise there is no guarantee that the bot will receive updates.
     * After a successful call, you can immediately log in on a local server,
     * but will not be able to log in back to the cloud Bot API server for 10 minutes.
     * Returns True on success. Requires no parameters.
     * @see https://core.telegram.org/bots/api#logout
     * @return bool|null
     */
    public function logOut(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     * You need to delete the webhook before calling this method to ensure that
     * the bot isn't launched again after server restart.
     * The method will return error 429 in the first 10 minutes after the bot is launched.
     * Returns True on success. Requires no parameters.
     * @see https://core.telegram.org/bots/api#close
     * @return bool|null
     */
    public function close(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * Use this method to send text messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendmessage
     * @param  string  $text Text of the message to be sent, 1-4096 characters after entities parsing
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
     * Use this method to forward messages of any kind. Service messages can't be forwarded.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#forwardmessage
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string|int  $from_chat_id Unique identifier for the chat where the original message was sent (or channel
     *     username in the format [at]channelusername)
     * @param  int  $message_id Message identifier in the chat specified in from_chat_id
     * @param  array  $opt
     * @return Message|null
     */
    public function forwardMessage(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,
        array $opt = []
    ): ?Message {
        $required = compact('chat_id', 'from_chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to copy messages of any kind. Service messages and invoice messages can't be copied.
     * The method is analogous to the method {@see https://core.telegram.org/bots/api#forwardmessage forwardMessage},
     * but the copied message doesn't have a link to the original message.
     * Returns the {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent message on success.
     * @see https://core.telegram.org/bots/api#copymessage
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string|int  $from_chat_id Unique identifier for the chat where the original message was sent (or channel
     *     username in the format [at]channelusername)
     * @param  int  $message_id Message identifier in the chat specified in from_chat_id
     * @param  array  $opt
     * @return MessageId|null
     */
    public function copyMessage(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,
        array $opt = []
    ): ?MessageId {
        $required = compact('chat_id', 'from_chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), MessageId::class);
    }

    /**
     * Use this method to send photos.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendphoto
     * @param  mixed  $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload
     *     a new photo using multipart/form-data. The photo must be at most 10 MB in size. The photo's width and height
     *     must not exceed 10000 in total. Width and height ratio must be at most 20.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendPhoto(mixed $photo, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'photo', $photo, $opt);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .MP3 or .M4A format.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     *
     * For sending voice messages, use the {@see https://core.telegram.org/bots/api#sendvoice sendVoice} method
     * instead.
     * @param  mixed  $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the
     *     Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the
     *     Internet, or upload a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendAudio(mixed $audio, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'audio', $audio, $opt);
    }

    /**
     * Use this method to send general files.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#senddocument
     * @param  mixed  $document File to send. Pass a file_id as String to send a file that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload
     *     a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendDocument(mixed $document, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'document', $document, $opt);
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos
     * (other formats may be sent as {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvideo
     * @param  mixed  $video Video to send. Pass a file_id as String to send a video that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload
     *     a new video using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVideo(mixed $video, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'video', $video, $opt);
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendanimation
     * @param  mixed  $animation Animation to send. Pass a file_id as String to send an animation that exists on the
     *     Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the
     *     Internet, or upload a new animation using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendAnimation(mixed $animation, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'animation', $animation, $opt);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice
     * message. For this to work, your audio must be in an .OGG file encoded with OPUS
     * (other formats may be sent as {@see https://core.telegram.org/bots/api#audio Audio}
     * or {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvoice
     * @param  mixed  $voice Audio file to send. Pass a file_id as String to send a file that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload
     *     a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVoice(mixed $voice, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'voice', $voice, $opt);
    }

    /**
     * As of {@see https://telegram.org/blog/video-messages-and-telescope v.4.0},
     * Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvideonote
     * @param  mixed  $video_note Video note to send. Pass a file_id as String to send a video note that exists on the
     *     Telegram servers (recommended) or upload a new video using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}. Sending video notes by
     *     a URL is currently unsupported
     * @param  array  $opt
     * @return Message|null
     */
    public function sendVideoNote(mixed $video_note, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'video_note', $video_note, $opt);
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album.
     * Documents and audio files can be only grouped in an album with messages of the same type.
     * On success, an array of {@see https://core.telegram.org/bots/api#message Messages} that were sent is returned.
     * @see https://core.telegram.org/bots/api#sendmediagroup
     * @param  array  $media An array describing messages to be sent, must include 2-10 items
     * @param  array  $opt
     * @return array|null
     * @throws JsonException
     */
    public function sendMediaGroup(array $media, array $opt = []): ?array
    {
        $inputMedia = [];
        $files = [];
        foreach ($media as $m) {
            if ($m instanceof InputMedia && is_resource($m->media)) {
                $id = uniqid(more_entropy:  true);
                $files[$id] = $m->media;
                $m->media = "attach://$id";
            } elseif (is_array($m) && is_resource($m['media'])) {
                $id = uniqid(more_entropy:  true);
                $files[$id] = $m['media'];
                $m['media'] = "attach://$id";
            }

            $inputMedia[] = $m;
        }

        $required = [
            'chat_id' => $this->chatId(),
            'media' => json_encode($inputMedia, JSON_THROW_ON_ERROR),
        ];
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $files, $opt), Message::class);
    }

    /**
     * Use this method to send point on the map.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendlocation
     * @param  float  $latitude Latitude of the location
     * @param  float  $longitude Longitude of the location
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
     * Use this method to edit live location messages.
     * A location can be edited until its live_period expires or editing is explicitly
     * disabled by a call to {@see https://core.telegram.org/bots/api#stopmessagelivelocation stopMessageLiveLocation}.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     * @param  float  $latitude Latitude of new location
     * @param  float  $longitude Longitude of new location
     * @param  array|null  $opt
     * @return Message|bool|null
     */
    public function editMessageLiveLocation(float $latitude, float $longitude, ?array $opt = []): Message|bool|null
    {
        $required = compact('latitude', 'longitude');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires.
     * On success, if the message was sent by the bot,
     * the sent {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     * @param  array|null  $opt
     * @return Message|bool|null
     */
    public function stopMessageLiveLocation(?array $opt = []): Message|bool|null
    {
        return $this->requestJson(__FUNCTION__, $opt, Message::class);
    }

    /**
     * Use this method to send information about a venue.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvenue
     * @param  float  $latitude Latitude of the venue
     * @param  float  $longitude Longitude of the venue
     * @param  string  $title Name of the venue
     * @param  string  $address Address of the venue
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendVenue(
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?array $opt = []
    ): ?Message {
        $chat_id = $this->chatId();
        $required = compact('latitude', 'longitude', 'chat_id', 'title', 'address');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to send phone contacts.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendcontact
     * @param  string  $first_name Contact's first name
     * @param  string  $phone_number Contact's phone number
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
     * Use this method to send a native poll.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendpoll
     * @param  string  $question Poll question, 1-300 characters
     * @param  string[]  $options A list of answer options, 2-10 strings 1-100 characters each
     * @param  array|null  $opt
     * @return Message|null
     * @throws JsonException
     */
    public function sendPoll(string $question, array $options, ?array $opt = []): ?Message
    {
        $required = [
            'chat_id' => $this->chatId(),
            'question' => $question,
            'options' => json_encode($options, JSON_THROW_ON_ERROR),
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to send an animated emoji that will display a random value.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#senddice
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
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less
     * (when a message arrives from your bot, Telegram clients clear its typing status).
     * Returns True on success.
     *
     * > Example: The {@see https://t.me/imagebot ImageBot} needs some time to process a request and upload the image.
     * > Instead of sending a text message along the lines of “Retrieving image, please wait…”, the bot may use
     * > {@see https://core.telegram.org/bots/api#sendchataction sendChatAction} with action = upload_photo.
     * > The user will see a “sending photo” status for the bot.
     *
     * We only recommend using this method when a response from the bot will take a noticeable amount of time to
     * arrive.
     * @see https://core.telegram.org/bots/api#sendchataction
     * @param  string  $action Type of action to broadcast. Choose one, depending on what the user is about to receive:
     *     typing for {@see https://core.telegram.org/bots/api#sendmessage text messages}, upload_photo for
     *     {@see https://core.telegram.org/bots/api#sendphoto photos}, record_video or upload_video for
     *     {@see https://core.telegram.org/bots/api#sendvideo videos}, record_voice or upload_voice for
     *     {@see https://core.telegram.org/bots/api#sendvoice voice notes}, upload_document for
     *     {@see https://core.telegram.org/bots/api#senddocument general files}, find_location for
     *     {@see https://core.telegram.org/bots/api#sendlocation location data}, record_video_note or upload_video_note
     *     for {@see https://core.telegram.org/bots/api#sendvideonote video notes}.
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
     * Use this method to get a list of profile pictures for a user.
     * Returns a {@see https://core.telegram.org/bots/api#userprofilephotos UserProfilePhotos} object.
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
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
     * Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download
     * files of up to 20MB in size. On success, a {@see https://core.telegram.org/bots/api#file File} object is
     * returned. The file can then be downloaded via the link `https://api.telegram.org/file/bot<token>/<file_path>`,
     * where `<file_path>` is taken from the response. It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling
     * {@see https://core.telegram.org/bots/api#getfile getFile} again.
     * @see https://core.telegram.org/bots/api#getfile
     * @param  string  $file_id File identifier to get info about
     * @return File|null
     */
    public function getFile(string $file_id): ?File
    {
        return $this->requestJson(__FUNCTION__, compact('file_id'), File::class);
    }

    /**
     * Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels,
     * the user will not be able to return to the chat on their own using invite links, etc., unless
     * {@see https://core.telegram.org/bots/api#unbanchatmember unbanned} first. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#kickchatmember
     * @param  string|int  $chat_id Unique identifier for the target group or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @param  int  $user_id Unique identifier of the target user
     * @param  array|null  $opt
     * @return bool|null
     * @deprecated Use {@see banChatMember} instead.
     */
    public function kickChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        return $this->banChatMember($chat_id, $user_id, $opt);
    }

    /**
     * Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels,
     * the user will not be able to return to the chat on their own using invite links, etc., unless
     * {@see https://core.telegram.org/bots/api#unbanchatmember unbanned} first. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#kickchatmember
     * @param  string|int  $chat_id Unique identifier for the target group or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @param  int  $user_id Unique identifier of the target user
     * @param  array|null  $opt
     * @return bool|null
     */
    public function banChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup or channel. The user will not return to the
     * group or channel automatically, but will be able to join via link, etc. The bot must be an administrator for
     * this to work. By default, this method guarantees that after the call the user is not a member of the chat, but
     * will be able to join it. So if the user is a member of the chat they will also be removed from the chat. If you
     * don't want this, use the parameter only_if_banned. Returns True on success.
     * @see https://core.telegram.org/bots/api#unbanchatmember
     * @param  string|int  $chat_id Unique identifier for the target group or username of the target supergroup or
     *     channel (in the format [at]username)
     * @param  int  $user_id Unique identifier of the target user
     * @param  array|null  $opt
     * @return bool|null
     */
    public function unbanChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup for this
     * to work and must have the appropriate admin rights. Pass True for all permissions to lift restrictions from a
     * user. Returns True on success.
     * @see https://core.telegram.org/bots/api#restrictchatmember
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @param  int  $user_id Unique identifier of the target user
     * @param  ChatPermissions  $permissions An object for new user permissions
     * @param  array|null  $opt
     * @return bool|null
     */
    public function restrictChatMember(
        string|int $chat_id,
        int $user_id,
        ChatPermissions $permissions,
        ?array $opt = []
    ): ?bool {
        $required = compact('chat_id', 'user_id');
        $required['permissions'] = json_encode($permissions);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights. Pass False for all boolean parameters to
     * demote a user. Returns True on success.
     * @see https://core.telegram.org/bots/api#promotechatmember
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  int  $user_id Unique identifier of the target user
     * @param  array|null  $opt
     * @return bool|null
     */
    public function promoteChatMember(string|int $chat_id, int $user_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'user_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot. Returns True on
     * success.
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @param  int  $user_id Unique identifier of the target user
     * @param  string  $custom_title New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setChatAdministratorCustomTitle(
        string|int $chat_id,
        int $user_id,
        string $custom_title,
        ?array $opt = []
    ): ?bool {
        $required = compact('chat_id', 'user_id', 'custom_title');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to set default chat permissions for all members. The bot must be an administrator in the group
     * or a supergroup for this to work and must have the can_restrict_members admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatpermissions
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @param  ChatPermissions  $permissions New default chat permissions
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
     * Use this method to generate a new primary invite link for a chat; any previously generated primary link is
     * revoked. The bot must be an administrator in the chat for this to work and must have the appropriate admin
     * rights. Returns the new invite link as String on success.
     *
     * Note: Each administrator in a chat generates their own invite links. Bots can't use invite links generated by
     * other administrators. If you want your bot to work with invite links, it will need to generate its own link
     * using {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink} or by calling the
     * {@see https://core.telegram.org/bots/api#getchat getChat} method. If your bot needs to generate a new primary
     * invite link replacing its previous one, use
     * {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink} again.
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format @channelusername)
     * @return string|null
     */
    public function exportChatInviteLink(string|int $chat_id): ?string
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. The link can be revoked using the method
     * {@see https://core.telegram.org/bots/api#revokechatinvitelink revokeChatInviteLink}. Returns the new invite link
     * as {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  array|null  $opt
     * @return ChatInviteLink|null
     */
    public function createChatInviteLink(string|int $chat_id, ?array $opt = []): ?ChatInviteLink
    {
        $required = compact('chat_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), ChatInviteLink::class);
    }

    /**
     * Use this method to edit a non-primary invite link created by the bot. The bot must be an administrator in the
     * chat for this to work and must have the appropriate admin rights. Returns the edited invite link as a
     * {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string  $invite_link The invite link to edit
     * @param  array|null  $opt
     * @return ChatInviteLink|null
     */
    public function editChatInviteLink(string|int $chat_id, string $invite_link, ?array $opt = []): ?ChatInviteLink
    {
        $required = compact('chat_id', 'invite_link');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), ChatInviteLink::class);
    }

    /**
     * Use this method to revoke an invite link created by the bot. If the primary link is revoked, a new link is
     * automatically generated. The bot must be an administrator in the chat for this to work and must have the
     * appropriate admin rights. Returns the revoked invite link as
     * {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     * @param  string|int  $chat_id Unique identifier of the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string  $invite_link The invite link to revoke
     * @return ChatInviteLink|null
     */
    public function revokeChatInviteLink(string|int $chat_id, string $invite_link): ?ChatInviteLink
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'invite_link'), ChatInviteLink::class);
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats. The bot must
     * be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on
     * success.
     * @see https://core.telegram.org/bots/api#setchatphoto
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  mixed  $photo New chat photo, uploaded using multipart/form-data
     * @return bool|null
     */
    public function setChatPhoto(string|int $chat_id, mixed $photo): ?bool
    {
        return $this->requestMultipart(__FUNCTION__, compact('chat_id', 'photo'));
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats. The bot must be an
     * administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatphoto
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @return bool|null
     */
    public function deleteChatPhoto(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to change the title of a chat. Titles can't be changed for private chats. The bot must be an
     * administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#setchattitle
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string  $title New chat title, 1-255 characters
     * @return bool|null
     */
    public function setChatTitle(string|int $chat_id, string $title): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'title'));
    }

    /**
     * Use this method to change the description of a group, a supergroup or a channel. The bot must be an
     * administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatdescription
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  string|null  $description New chat description, 0-255 characters
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
     * Use this method to add a message to the list of pinned messages in a chat. If the chat is not a private chat,
     * the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' admin right
     * in a supergroup or 'can_edit_messages' admin right in a channel. Returns True on success.
     * @see https://core.telegram.org/bots/api#pinchatmessage
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  int  $message_id Identifier of a message to pin
     * @param  array|null  $opt
     * @return bool|null
     */
    public function pinChatMessage(string|int $chat_id, int $message_id, ?array $opt = []): ?bool
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to remove a message from the list of pinned messages in a chat. If the chat is not a private
     * chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' admin
     * right in a supergroup or 'can_edit_messages' admin right in a channel. Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  int  $message_id Identifier of a message to unpin. If not specified, the most recent pinned message (by
     *     sending date) will be unpinned.
     * @return bool|null
     */
    public function unpinChatMessage(string|int $chat_id, int $message_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }

    /**
     * Use this method to clear the list of pinned messages in a chat. If the chat is not a private chat, the bot must
     * be an administrator in the chat for this to work and must have the 'can_pin_messages' admin right in a
     * supergroup or 'can_edit_messages' admin right in a channel. Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @return bool|null
     */
    public function unpinAllChatMessages(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     * @see https://core.telegram.org/bots/api#leavechat
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @return bool|null
     */
    public function leaveChat(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one
     * conversations, current username of a user, group or channel, etc.). Returns a
     * {@see https://core.telegram.org/bots/api#chat Chat} object on success.
     * @see https://core.telegram.org/bots/api#getchat
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @return Chat|null
     */
    public function getChat(string|int $chat_id): ?Chat
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), Chat::class);
    }

    /**
     * Use this method to get a list of administrators in a chat. On success, returns an Array of
     * {@see https://core.telegram.org/bots/api#chatmember ChatMember} objects that contains information about all chat
     * administrators except other bots. If the chat is a group or a supergroup and no administrators were appointed,
     * only the creator will be returned.
     * @see https://core.telegram.org/bots/api#getchatadministrators
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @return array|null
     */
    public function getChatAdministrators(string|int $chat_id): ?array
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), ChatMember::class);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     * @see https://core.telegram.org/bots/api#getchatmemberscount
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @return int|null
     * @deprecated Use {@see getChatMemberCount} instead.
     */
    public function getChatMembersCount(string|int $chat_id): ?int
    {
        return $this->getChatMemberCount($chat_id);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     * @see https://core.telegram.org/bots/api#getchatmemberscount
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @return int|null
     */
    public function getChatMemberCount(string|int $chat_id): ?int
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to get information about a member of a chat. Returns a
     * {@see https://core.telegram.org/bots/api#chatmember ChatMember} object on success.
     * @see https://core.telegram.org/bots/api#getchatmember
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup or
     *     channel (in the format [at]channelusername)
     * @param  int  $user_id Unique identifier of the target user
     * @return ChatMember|null
     */
    public function getChatMember(string|int $chat_id, int $user_id): ?ChatMember
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'), ChatMember::class);
    }

    /**
     * Use this method to set a new group sticker set for a supergroup. The bot must be an administrator in the chat
     * for this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally
     * returned in {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this
     * method. Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatstickerset
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @param  string  $sticker_set_name Name of the sticker set to be set as the group sticker set
     * @return bool|null
     */
    public function setChatStickerSet(string|int $chat_id, string $sticker_set_name): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'sticker_set_name'));
    }

    /**
     * Use this method to delete a group sticker set from a supergroup. The bot must be an administrator in the chat
     * for this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally
     * returned in {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this
     * method. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatstickerset
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target supergroup (in the
     *     format [at]supergroupusername)
     * @return bool|null
     */
    public function deleteChatStickerSet(string|int $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to send answers to callback queries sent from
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating inline keyboards}. The answer will
     * be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is
     * returned.
     *
     * > Alternatively, the user can be redirected to the specified Game URL.
     * > For this option to work, you must first create a game for your bot via
     * > {@see https://t.me/botfather [at]Botfather} and accept the terms.
     * > Otherwise, you may use links like `t.me/your_bot?start=XXXX` that open your bot with a parameter.
     * @see https://core.telegram.org/bots/api#answercallbackquery
     * @param  array|null  $opt
     * @return bool|null
     */
    public function answerCallbackQuery(?array $opt = []): ?bool
    {
        $required = ['callback_query_id' => $this->callbackQuery()?->id];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to change the list of the bot's commands. Returns True on success.
     * @see https://core.telegram.org/bots/api#setmycommands
     * @param  BotCommand[]  $commands A list of bot commands to be set as the list of the bot's commands. At most 100
     *     commands can be specified.
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setMyCommands(array $commands = [], ?array $opt = []): ?bool
    {
        $required = ['commands' => json_encode($commands)];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * Use this method to delete the list of the bot's commands for the given scope and user language.
     * After deletion, {@see https://core.telegram.org/bots/api#determining-list-of-commands higher level commands}
     * will be shown to affected users. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemycommands
     * @param  array|null  $opt
     * @return bool
     */
    public function deleteMyCommands(?array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, $opt);
    }

    /**
     * Use this method to get the current list of the bot's commands. Requires no parameters. Returns Array of
     * {@see https://core.telegram.org/bots/api#botcommand BotCommand} on success.
     * @see https://core.telegram.org/bots/api#getmycommands
     * @param  array|null  $opt
     * @return BotCommand[]|null
     */
    public function getMyCommands(?array $opt = []): ?array
    {
        return $this->requestJson(__FUNCTION__, $opt, BotCommand::class);
    }
}
