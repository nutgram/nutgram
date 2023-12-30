<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

/**
 * The reaction is based on an emoji.
 * @see https://core.telegram.org/bots/api#reactiontypeemoji
 */
class ReactionTypeEmoji extends ReactionType
{
    public const THUMBS_UP = '👍';
    public const THUMBS_DOWN = '👎';
    public const HEART = '❤️';
    public const FIRE = '🔥';
    public const SMILING_FACE_WITH_HEARTS = '🥰';
    public const APPLAUSE = '👏';
    public const BEAMING_FACE = '😁';
    public const THINKING_FACE = '🤔';
    public const EXPLODING_HEAD = '🤯';
    public const SCREAMING_FACE = '😱';
    public const FACE_WITH_SYMBOLS_ON_MOUTH = '🤬';
    public const CRYING_FACE = '😢';
    public const PARTY_POPPER = '🎉';
    public const STAR_STRUCK = '🤩';
    public const FACE_VOMITING = '🤮';
    public const POO = '💩';
    public const FOLDED_HANDS = '🙏';
    public const OK_HAND = '👌';
    public const DOVE = '🕊️';
    public const CLOWN_FACE = '🤡';
    public const YAWNING_FACE = '🥱';
    public const WOOZY_FACE = '🥴';
    public const SMILING_FACE_WITH_HEART_EYES = '😍';
    public const WHALE = '🐳';
    public const FIRING_HEART = "❤‍🔥";
    public const NEW_MOON_FACE = '🌚';
    public const HOT_DOG = '🌭';
    public const HUNDRED_POINTS = '💯';
    public const ROLLING_ON_THE_FLOOR_LAUGHING = '🤣';
    public const HIGH_VOLTAGE = '⚡';
    public const BANANA = '🍌';
    public const TROPHY = '🏆';
    public const BROKEN_HEART = '💔';
    public const FACE_WITH_RAISED_EYEBROW = '🤨';
    public const NEUTRAL_FACE = '😐';
    public const STRAWBERRY = '🍓';
    public const CHAMPAGNE = '🍾';
    public const KISS = '💋';
    public const MIDDLE_FINGER = '🖕';
    public const SMILING_FACE_WITH_HORNS = '😈';
    public const SLEEPING_FACE = '😴';
    public const LOUDLY_CRYING_FACE = '😭';
    public const NERD_FACE = '🤓';
    public const GHOST = '👻';
    public const MAN_TECHNOLOGIST = "👨‍💻";
    public const EYES = '👀';
    public const JACK_O_LANTERN = '🎃';
    public const SEE_NO_EVIL = '🙈';
    public const SMILING_FACE_WITH_HALO = '😇';
    public const FEARFUL_FACE = '😨';
    public const HANDSHAKE = '🤝';
    public const WRITING_HAND = '✍️';
    public const HUGGING_FACE = '🤗';
    public const SALUTING_FACE = '🫡';
    public const SANTA_CLAUS = '🎅';
    public const CHRISTMAS_TREE = '🎄';
    public const SNOWMAN = '⛄';
    public const NAIL_POLISH = '💅';
    public const ZANY_FACE = '🤪';
    public const MOAI = '🗿';
    public const COOL = '🆒';
    public const HEART_WITH_ARROW = '💘';
    public const HEAR_NO_EVIL = '🙉';
    public const UNICORN = '🦄';
    public const KISSING_FACE = '😘';
    public const PILL = '💊';
    public const SPEAK_NO_EVIL = '🙊';
    public const SMILING_FACE_WITH_SUNGLASSES = '😎';
    public const ALIEN_MONSTER = '👾';
    public const SHRUGGING_MAN = "🤷‍♂";
    public const SHRUGGING_NEUTRAL = '🤷';
    public const SHRUGGING_WOMAN = "🤷‍♀";
    public const ENRAGED_FACE = '😡';

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
