<?php

namespace SergiX44\Nutgram\Support;

/**
 * @see https://core.telegram.org/api/links
 */
class DeepLink
{
    protected const DEFAULT_BASEURL = 'https://t.me/';
    protected ?string $baseUrl;

    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl ?? self::DEFAULT_BASEURL;
    }

    public static function make(?string $baseUrl = null): self
    {
        return new self($baseUrl);
    }

    /**
     * ### Public username link
     * Used to link to public users, groups and channels.
     *
     * Example: https:\/\/t.me/\<username\>
     * @see https://core.telegram.org/api/links#public-username-links
     * @param string $username Username
     * @return string
     */
    public function username(string $username): string
    {
        return $this->buildUrl($username);
    }

    /**
     * ### Temporary profile link
     * Used to link to user profiles that don't have a username, and they have an expiration date.
     *
     * Example: https:\/\/t.me/contact/\<token\>
     * @see https://core.telegram.org/api/links#temporary-profile-links
     * @param string $token Profile token
     * @return string
     */
    public function contact(string $token): string
    {
        return $this->buildUrl("contact/$token");
    }

    /**
     * ### Phone number links
     * Used to link to public and private users by their phone number.
     *
     * Example: https:\/\/t.me/+\<phone_number\>
     * @see https://core.telegram.org/api/links#phone-number-links
     * @param int $prefix
     * @param int $phone
     * @return string
     */
    public function phone(int $prefix, int $phone): string
    {
        return $this->buildUrl("+$prefix$phone");
    }

    /**
     * ### Chat invite links
     * Used to invite users to private groups and channels.
     *
     * Example : https:\/\/t.me/+\<hash\>
     *
     * Example (legacy): https:\/\/t.me/joinchat/\<hash\>
     * @see https://core.telegram.org/api/links#chat-invite-links
     * @param string $hash
     * @param bool $legacy
     * @return string
     */
    public function joinChat(string $hash, bool $legacy = false): string
    {
        if ($legacy) {
            return $this->buildUrl("joinchat/$hash");
        }

        return $this->buildUrl("+$hash");
    }

    /**
     * ### Chat folder links
     * Used to invite users to private groups and channels.
     *
     * Example: https:\/\/t.me/addlist/\<slug\>
     * @see https://core.telegram.org/api/links#chat-folder-links
     * @param string $slug
     * @return string
     */
    public function addList(string $slug): string
    {
        return $this->buildUrl("addlist/$slug");
    }

    /**
     * ### Public message links
     * Used to link to specific messages in public groups and channels.
     *
     * Example: https:\/\/t.me/\<username\>\/<thread_id?\>/\<message_id\>
     * @see https://core.telegram.org/api/links#message-links
     * @param string $username
     * @param int $messageId
     * @param int|null $threadId
     * @param bool $single
     * @param int|null $comment
     * @param string|null $mediaTimestamp
     * @return string
     */
    public function publicMessage(
        string $username,
        int $messageId,
        ?int $threadId = null,
        bool $single = false,
        ?int $comment = null,
        ?string $mediaTimestamp = null,
    ): string {
        if ($threadId === null) {
            $endpoint = $username.'/'.$messageId;
        } else {
            $endpoint = $username.'/'.$threadId.'/'.$messageId;
        }

        return $this->buildUrl($endpoint, [
            'single' => $single ? '' : null,
            'comment' => $comment,
            't' => $mediaTimestamp,
        ]);
    }

    /**
     * ### Private message links
     * Used to link to specific messages in private chats.
     *
     * Example: https:\/\/t.me/c/\<chat_id\>/\<thread_id?\>/\<message_id\>
     * @see https://core.telegram.org/api/links#message-links
     * @param int $chatId
     * @param int $messageId
     * @param int|null $threadId
     * @param bool $single
     * @param int|null $comment
     * @param string|null $mediaTimestamp
     * @return string
     */
    public function privateMessage(
        int $chatId,
        int $messageId,
        ?int $threadId = null,
        bool $single = false,
        ?int $comment = null,
        ?string $mediaTimestamp = null,
    ): string {
        if ($threadId === null) {
            $endpoint = "c/$chatId/$messageId";
        } else {
            $endpoint = "c/$chatId/$threadId/$messageId";
        }

        return $this->buildUrl($endpoint, [
            'single' => $single ? '' : null,
            'comment' => $comment,
            't' => $mediaTimestamp,
        ]);
    }

    /**
     * ### Public forum topic links
     * Used to link to a specific forum topic.
     * The syntax is exactly the same as for message links,
     * because the topic ID is actually the ID of the service message that created the topic.
     *
     * Example: https:\/\/t.me/\<username\>\/<topic_id\>
     * @see https://core.telegram.org/api/links#forum-topic-links
     * @param string $username
     * @param string $topicId
     * @return string
     */
    public function publicForumTopic(string $username, string $topicId): string
    {
        return $this->publicMessage($username, $topicId);
    }

    /**
     * ### Private forum topic links
     * Used to link to a specific forum topic.
     * The syntax is exactly the same as for message links,
     * because the topic ID is actually the ID of the service message that created the topic.
     *
     * Example: https:\/\/t.me/c/\<chat_id\>/\<topic_id\>
     * @see https://core.telegram.org/api/links#forum-topic-links
     * @param int $chatId
     * @param string $topicId
     * @return string
     */
    public function privateForumTopic(int $chatId, string $topicId): string
    {
        return $this->privateMessage($chatId, $topicId);
    }

    /**
     * ### Share links
     * Used to share a prepared message and URL into a chosen chat's text field.
     *
     * Example: https:\/\/t.me/share?url=\<url\>&text=\<text?\>
     * @see https://core.telegram.org/api/links#share-links
     * @param string $url
     * @param string|null $text
     * @return string
     */
    public function share(string $url, ?string $text = null): string
    {
        return $this->buildUrl('share', [
            'url' => $url,
            'text' => $text,
        ]);
    }

    /**
     * ### Video chat links
     * Used to join video/voice chats in groups.
     *
     * Example: https:\/\/t.me/\<username\>?videochat=\<invite_hash?\>
     * @see https://core.telegram.org/api/links#video-chat-livestream-links
     * @param string $username
     * @param string $inviteHash
     * @return string
     */
    public function videochat(string $username, string $inviteHash = ''): string
    {
        return $this->buildUrl($username, [
            'videochat' => $inviteHash,
        ]);
    }

    /**
     * ### Livestream links
     * Used to join livestreams in channels.
     *
     * Example: https:\/\/t.me/\<username\>?livestream=\<invite_hash?\>
     * @see https://core.telegram.org/api/links#video-chat-livestream-links
     * @param string $username
     * @param string $inviteHash
     * @return string
     */
    public function livestream(string $username, string $inviteHash = ''): string
    {
        return $this->buildUrl($username, [
            'livestream' => $inviteHash,
        ]);
    }

    /**
     * ### Stickerset links
     * Used to import stickersets.
     *
     * Example: https:\/\/t.me/addstickers/\<slug\>
     * @see https://core.telegram.org/api/links#stickerset-links
     * @param string $slug
     * @return string
     */
    public function addStickers(string $slug): string
    {
        return $this->buildUrl("addstickers/$slug");
    }

    /**
     * ### Custom emojiset links
     * Used to import custom emojisets.
     *
     * Example: https:\/\/t.me/addemoji/\<slug\>
     * @see https://core.telegram.org/api/links#custom-emoji-stickerset-links
     * @param string $slug
     * @return string
     */
    public function addEmoji(string $slug): string
    {
        return $this->buildUrl("addemoji/$slug");
    }

    /**
     * ### Story links
     * Used to link to a Telegram Story.
     *
     * Example: https:\/\/t.me/\<username\>/s/\<story_id\>
     * @see https://core.telegram.org/api/links#story-links
     * @param string $username
     * @param int $storyId
     * @return string
     */
    public function story(string $username, int $storyId): string
    {
        return $this->buildUrl("$username/s/$storyId");
    }

    /**
     * ### Public boost links
     * Used by users to boost groups/channels.
     *
     * Example: https:\/\/t.me/boost/\<username\>
     * @see https://core.telegram.org/api/links#boost-links
     * @param string $username
     * @return string
     */
    public function publicBoost(string $username): string
    {
        return $this->buildUrl("boost/$username");
    }

    /**
     * ### Private boost links
     * Used by users to boost groups/channels.
     *
     * Example: https:\/\/t.me/boost?c=\<chat_id\>
     * @see https://core.telegram.org/api/links#boost-links
     * @param int $chatId
     * @return string
     */
    public function privateBoost(int $chatId): string
    {
        return $this->buildUrl('boost', [
            'c' => $chatId,
        ]);
    }

    /**
     * ### MTProxy links
     * Used to share a MTProxy server that can be used to connect to Telegram.
     *
     * Example: https:\/\/t.me/proxy?server=\<server\>&port=\<port\>&secret=\<secret\>
     * @see https://core.telegram.org/api/links#mtproxy-links
     * @param string $server
     * @param int $port
     * @param string $secret
     * @return string
     */
    public function proxyMTP(string $server, int $port, string $secret): string
    {
        return $this->buildUrl('proxy', [
            'server' => $server,
            'port' => $port,
            'secret' => $secret,
        ]);
    }

    /**
     * ### Socks5 proxy links
     * Used to share a Socks5 server that can be used to connect to Telegram.
     *
     * Example: https:\/\/t.me/socks?server=\<server\>&port=\<port\>&user=\<user\>&pass=\<pass\>
     * @see https://core.telegram.org/api/links#socks5-proxy-links
     * @param string $server
     * @param int $port
     * @param string $user
     * @param string $pass
     * @return string
     */
    public function proxySocks5(string $server, int $port, string $user, string $pass): string
    {
        return $this->buildUrl('socks', [
            'server' => $server,
            'port' => $port,
            'user' => $user,
            'pass' => $pass,
        ]);
    }

    /**
     * ### Theme links
     * Used to install themes.
     *
     * Example: https:\/\/t.me/addtheme/\<slug\>
     * @see https://core.telegram.org/api/links#theme-links
     * @param string $slug
     * @return string
     */
    public function addTheme(string $slug): string
    {
        return $this->buildUrl("addtheme/$slug");
    }

    /**
     * ### Image wallpapers
     * Used for image-based wallpapers.
     *
     * Example: https:\/\/t.me/bg/\<slug\>?mode=\<mode?\>
     * @see https://core.telegram.org/api/links#image-wallpapers
     * @param string $slug
     * @param string|null $mode A combination of blur and motion (joined by +) to enable blurring and/or parallax motion
     * @return string
     */
    public function wallpaperImage(string $slug, array $mode = []): string
    {
        return $this->buildUrl("bg/$slug", [
            'mode' => implode(' ', $mode),
        ]);
    }

    /**
     * ### Solid fill wallpapers
     * Used for fill wallpapers with a solid fill.
     *
     * Example: https:\/\/t.me/bg/\<hex_color\>
     * @see https://core.telegram.org/api/links#solid-fill-wallpapers
     * @param string $hexColor
     * @return string
     */
    public function wallpaperSolidFill(string $hexColor): string
    {
        return $this->buildUrl("bg/$hexColor");
    }

    /**
     * ### Gradient fill wallpapers
     * Used for fill wallpapers with a gradient fill.
     *
     * Example: https:\/\/t.me/bg/\<top_color\>-\<bottom_color\>?rotation=\<rotation?\>
     * @see https://core.telegram.org/api/links#gradient-fill-wallpapers
     * @param string $topColor Top gradient color in hex RGB format.
     * @param string $bottomColor Bottom gradient color in hex RGB format.
     * @param int $rotation Clockwise rotation angle of the gradient, in degrees; 0-359. Must be always divisible by 45, default to 0 if not set.
     * @return string
     */
    public function wallpaperGradientFill(string $topColor, string $bottomColor, int $rotation = 0): string
    {
        return $this->buildUrl("bg/$topColor-$bottomColor", [
            'rotation' => $rotation,
        ]);
    }

    /**
     * ### Freeform gradient fill wallpapers
     * Used for fill wallpapers with a freeform gradient fill.
     *
     * Example: https:\/\/t.me/bg/\<color1\>~\<color2\>~\<color3\>~\<color4?\>
     * @see https://core.telegram.org/api/links#freeform-gradient-fill-wallpapers
     * @param string $hexColor1
     * @param string $hexColor2
     * @param string $hexColor3
     * @param string|null $hexColor4
     * @return string
     */
    public function wallpaperFreeformGradientFill(
        string $hexColor1,
        string $hexColor2,
        string $hexColor3,
        ?string $hexColor4 = null,
    ): string {
        $colors = [$hexColor1, $hexColor2, $hexColor3];

        if ($hexColor4 !== null) {
            $colors[] = $hexColor4;
        }

        return $this->buildUrl(sprintf("bg/%s", implode('~', $colors)));
    }

    /**
     * ### Solid pattern wallpapers
     * Used for pattern wallpapers with a solid fill.
     *
     * Example: https:\/\/t.me/bg/\<slug\>?intensity=\<intensity\>&bg_color=\<bg_color\>&mode=\<mode?\>
     * @see https://core.telegram.org/api/links#solid-pattern-wallpapers
     * @param string $slug
     * @param int $intensity
     * @param string $bgColor
     * @param string|null $mode
     * @return string
     */
    public function wallpaperSolidPattern(string $slug, int $intensity, string $bgColor, array $mode = []): string
    {
        return $this->buildUrl("bg/$slug", [
            'intensity' => $intensity,
            'bg_color' => $bgColor,
            'mode' => implode(' ', $mode),
        ]);
    }

    /**
     * ### Gradient pattern wallpapers
     * Used for pattern wallpapers with a gradient fill.
     *
     * Example: https:\/\/t.me/bg/\<slug\>?intensity=\<intensity\>&top_color=\<top_color\>&bottom_color=\<bottom_color\>&rotation=\<rotation\>&mode=\<mode?\>
     * @see https://core.telegram.org/api/links#gradient-pattern-wallpapers
     * @param string $slug
     * @param int $intensity
     * @param string $topColor
     * @param string $bottomColor
     * @param int $rotation
     * @param string|null $mode
     * @return string
     */
    public function wallpaperGradientPattern(
        string $slug,
        int $intensity,
        string $topColor,
        string $bottomColor,
        int $rotation = 0,
        array $mode = [],
    ): string {
        return $this->buildUrl("bg/$slug", [
            'intensity' => $intensity,
            'top_color' => $topColor,
            'bottom_color' => $bottomColor,
            'rotation' => $rotation,
            'mode' => implode(' ', $mode),
        ]);
    }

    /**
     * ### Freeform gradient pattern wallpapers
     * Used for pattern wallpapers with a freeform gradient fill.
     *
     * Example: https:\/\/t.me/bg/\<slug\>?intensity=\<intensity\>&bg_color=\<hex_color1\>~\<hex_color2\>~\<hex_color3\>~\<hex_color4?\>&mode=\<mode?\>
     * @see https://core.telegram.org/api/links#freeform-gradient-pattern-wallpapers
     * @param string $slug
     * @param int $intensity
     * @param string $hexColor1
     * @param string $hexColor2
     * @param string $hexColor3
     * @param string|null $hexColor4
     * @param string|null $mode
     * @return string
     */
    public function wallpaperFreeformGradientPattern(
        string $slug,
        int $intensity,
        string $hexColor1,
        string $hexColor2,
        string $hexColor3,
        ?string $hexColor4 = null,
        array $mode = [],
    ): string {
        $colors = [$hexColor1, $hexColor2, $hexColor3];
        if ($hexColor4 !== null) {
            $colors[] = $hexColor4;
        }

        return $this->buildUrl("bg/$slug", [
            'intensity' => $intensity,
            'bg_color' => implode('~', $colors),
            'mode' => implode(' ', $mode),
        ]);
    }

    /**
     * ### Bot links
     * Used to link to bots.
     *
     * Example: https:\/\/t.me/\<bot_username\>?start=\<value\>
     * @see https://core.telegram.org/api/links#bot-links
     * @param string $botUsername
     * @param string $value
     * @return string
     */
    public function start(string $botUsername, string $value): string
    {
        return $this->buildUrl($botUsername, [
            'start' => $value
        ]);
    }

    /**
     * ### Group bot links
     * Used to add bots to groups.
     *
     * Example: https:\/\/t.me/\<bot_username\>?startgroup=\<value\>&admin=\<permission1\>+\<permission2\> ...
     * @see https://core.telegram.org/api/links#group-channel-bot-links
     * @param string $botUsername
     * @param string $value
     * @param array $admin
     * @return string
     */
    public function startGroup(string $botUsername, string $value, array $admin = []): string
    {
        return $this->buildUrl($botUsername, [
            'startgroup' => $value,
            'admin' => implode(' ', $admin),
        ]);
    }

    /**
     * ### Channel bot links
     * Used to add bots to groups or channels.
     *
     * Example: https:\/\/t.me/\<bot_username\>?startchannel&admin=\<permission1\>+\<permission2\> ...
     * @see https://core.telegram.org/api/links#group-channel-bot-links
     * @param string $botUsername
     * @param array $admin
     * @return string
     */
    public function startChannel(string $botUsername, array $admin = []): string
    {
        return $this->buildUrl($botUsername, [
            'startchannel' => '',
            'admin' => implode(' ', $admin),
        ]);
    }

    /**
     * ### Game links
     * Used to share games.
     *
     * Example: https:\/\/t.me/\<bot_username\>?game=\<short_name\>
     * @see https://core.telegram.org/api/links#game-links
     * @param string $botUsername
     * @param string $shortName
     * @return string
     */
    public function game(string $botUsername, string $shortName): string
    {
        return $this->buildUrl($botUsername, [
            'game' => $shortName
        ]);
    }

    /**
     * ### Login code link
     * Contains the phone number verification code to use during user authorization.
     *
     * Example: https:\/\/t.me/login/\<code\>
     * @see https://core.telegram.org/api/links#login-code-link
     * @param string $code
     * @return string
     */
    public function login(string $code): string
    {
        return $this->buildUrl("login/$code");
    }

    /**
     * ### Invoice links
     * Used to initiate payment of an invoice.
     *
     * Example: https:\/\/t.me/invoice/\<slug\>
     * @see https://core.telegram.org/api/links#invoice-links
     * @param string $slug
     * @return string
     */
    public function invoice(string $slug): string
    {
        return $this->buildUrl("invoice/$slug");
    }

    /**
     * ### Language pack links
     * Used to import custom language packs.
     *
     * Example: https:\/\/t.me/setlanguage/\<slug\>
     * @see https://core.telegram.org/api/links#language-pack-links
     * @param string $slug
     * @return string
     */
    public function setLanguage(string $slug): string
    {
        return $this->buildUrl("setlanguage/$slug");
    }

    /**
     * ### Phone confirmation links
     * These links are used to confirm ownership of the phone number, to prevent account deletion.
     *
     * Example: https:\/\/t.me/confirmphone?phone=\<phone\>&hash=\<hash\>
     * @see https://core.telegram.org/api/links#phone-confirmation-links
     * @param string $phone
     * @param string $hash
     * @return string
     */
    public function confirmPhone(string $phone, string $hash): string
    {
        return $this->buildUrl('confirmphone', [
            'phone' => $phone,
            'hash' => $hash,
        ]);
    }

    /**
     * ### Premium giftcode links
     * Used to process Telegram Premium giftcode links.
     *
     * Example: https:\/\/t.me/giftcode/\<slug\>
     * @see https://core.telegram.org/api/links#premium-giftcode-links
     * @param string $slug
     * @return string
     */
    public function giftcode(string $slug): string
    {
        return $this->buildUrl("giftcode/$slug");
    }

    /**
     * ### Mini App links
     * Used to install and open a bot attachment or side menu.
     *
     * Example: https:\/\/t.me/\<bot_username\>?startapp=\<value?\>
     * @see https://core.telegram.org/api/links#mini-app-links
     * @param string $botUsername
     * @param string $value
     * @return string
     */
    public function startApp(string $botUsername, string $value = ''): string
    {
        return $this->buildUrl($botUsername, [
            'startapp' => $value,
        ]);
    }

    /**
     * ### Direct mini app links
     * Used to share Direct link Mini apps.
     *
     * Example: https:\/\/t.me/\<bot_username\>/\<app_name\>?startapp=\<start_parameter?\>
     * @see https://core.telegram.org/api/links#direct-mini-app-links
     * @param string $botUsername
     * @param string $appName
     * @param string|null $startParameter
     * @return string
     */
    public function miniApp(string $botUsername, string $appName, ?string $startParameter = null): string
    {
        return $this->buildUrl("$botUsername/$appName", [
            'startapp' => $startParameter,
        ]);
    }

    /**
     * ### Bot attachment or side menu links
     * #### Open in current chat + Open in any chat
     * Used to install and open a bot attachment or side menu in a certain chat.
     *
     * Example: https:\/\/t.me/\<bot_username\>?startattach=\<start_parameter?\>
     *
     * Example: https:\/\/t.me/\<bot_username\>?startattach=\<start_parameter?\>&choose=\<choose1\>+\<choose2\> ...
     * @see https://core.telegram.org/api/links#open-in-current-chat Open in current chat
     * @see https://core.telegram.org/api/links#open-in-any-chat Open in any chat
     * @param string $botUsername
     * @param string|null $startParameter
     * @param array $choose A combination of users, bots, groups, channels
     * @return string
     */
    public function startAttach(string $botUsername, ?string $startParameter = null, array $choose = []): string
    {
        return $this->buildUrl($botUsername, [
            'startattach' => $startParameter,
            'choose' => implode(' ', $choose),
        ]);
    }

    /**
     * ### Bot attachment or side menu links
     * #### Open in specific chat
     * Used to install and open a bot attachment or side menu in a certain chat.
     *
     * Example: https:\/\/t.me/\<usernameOrPhone\>?attach=\<bot_username\>&startattach=\<start_parameter?\>
     * @see https://core.telegram.org/api/links#open-in-specific-chat
     * @param string $usernameOrPhone
     * @param string $botUsername
     * @param string|null $startParameter
     * @return string
     */
    public function attach(string $usernameOrPhone, string $botUsername, ?string $startParameter = null): string
    {
        return $this->buildUrl($usernameOrPhone, [
            'attach' => $botUsername,
            'startattach' => $startParameter,
        ]);
    }

    protected function buildUrl(string $endpoint, array $query = []): string
    {
        if (empty($query)) {
            return $this->baseUrl.$endpoint;
        }

        return $this->baseUrl.$endpoint.$this->buildSafeQuery($query);
    }

    protected function buildSafeQuery(array $params = []): string
    {
        $value = http_build_query($params);
        $value = str_replace(['=&', '%7E'], ['&', '~'], $value);
        if (str_ends_with($value, '=')) {
            $value = substr($value, 0, -1);
        }

        if (!empty($value)) {
            $value = '?'.$value;
        }

        return $value;
    }
}
