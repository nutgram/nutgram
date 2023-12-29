<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

/**
 * The reaction is based on an emoji.
 * @see https://core.telegram.org/bots/api#reactiontypeemoji
 */
class ReactionTypeEmoji extends ReactionType
{
    /**
     * Type of the reaction, always “emoji”
     * @var ReactionTypeType
     */
    public ReactionTypeType $type = ReactionTypeType::EMOJI;

    /**
     * Reaction emoji. Currently, it can be one of
     * "👍", "👎", "❤", "🔥", "🥰", "👏", "😁", "🤔", "🤯", "😱", "🤬", "😢", "🎉", "🤩", "🤮", "💩",
     * "🙏", "👌", "🕊", "🤡", "🥱", "🥴", "😍", "🐳", "❤‍🔥", "🌚", "🌭", "💯", "🤣", "⚡", "🍌", "🏆",
     * "💔", "🤨", "😐", "🍓", "🍾", "💋", "🖕", "😈", "😴", "😭", "🤓", "👻", "👨‍💻", "👀", "🎃", "🙈",
     * "😇", "😨", "🤝", "✍", "🤗", "🫡", "🎅", "🎄", "☃", "💅", "🤪", "🗿", "🆒", "💘", "🙉", "🦄",
     * "😘", "💊", "🙊", "😎", "👾", "🤷‍♂", "🤷", "🤷‍♀", "😡"
     * @var string
     */
    public string $emoji;
}
