<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Game\Game;
use SergiX44\Nutgram\Telegram\Types\Giveaway\Giveaway;
use SergiX44\Nutgram\Telegram\Types\Giveaway\GiveawayWinners;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Location\Venue;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\Contact;
use SergiX44\Nutgram\Telegram\Types\Media\Dice;
use SergiX44\Nutgram\Telegram\Types\Media\Document;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Media\Story;
use SergiX44\Nutgram\Telegram\Types\Media\Video;
use SergiX44\Nutgram\Telegram\Types\Media\VideoNote;
use SergiX44\Nutgram\Telegram\Types\Media\Voice;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOrigin;
use SergiX44\Nutgram\Telegram\Types\Payment\Invoice;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaInfo;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;

/**
 * This object contains information about a message that is being replied to, which may come from another chat or forum topic.
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
class ExternalReplyInfo extends BaseType
{
    /**
     * Origin of the message replied to by the given message
     * @var MessageOrigin
     */
    public MessageOrigin $origin;

    /**
     * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
     * @var Chat|null
     */
    public ?Chat $chat = null;

    /**
     * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
     * @var int|null
     */
    public ?int $message_id = null;

    /**
     * Optional. Options used for link preview generation for the original message, if it is a text message
     * @var LinkPreviewOptions|null
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    /**
     * Optional. Message is an animation, information about the animation
     * @var Animation|null
     */
    public ?Animation $animation = null;

    /**
     * Optional. Message is an audio file, information about the file
     * @var Audio|null
     */
    public ?Audio $audio = null;

    /**
     * Optional. Message is a general file, information about the file
     * @var Document|null
     */
    public ?Document $document = null;

    /**
     * Optional. Message contains paid media; information about the paid media
     */
    public ?PaidMediaInfo $paid_media = null;

    /**
     * Optional. Message is a photo, available sizes of the photo
     * @var PhotoSize[]|null
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;

    /**
     * Optional. Message is a sticker, information about the sticker
     * @var Sticker|null
     */
    public ?Sticker $sticker = null;

    /**
     * Optional. Message is a forwarded story
     * @var Story|null
     */
    public ?Story $story = null;

    /**
     * Optional. Message is a video, information about the video
     * @var Video|null
     */
    public ?Video $video = null;

    /**
     * Optional. Message is a video note, information about the video message
     * @var VideoNote|null
     */
    public ?VideoNote $video_note = null;

    /**
     * Optional. Message is a voice message, information about the file
     * @var Voice|null
     */
    public ?Voice $voice = null;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     * @var bool|null
     */
    public ?bool $has_media_spoiler = null;

    /**
     * Optional. Message is a shared contact, information about the contact
     * @var Contact|null
     */
    public ?Contact $contact = null;

    /**
     * Optional. Message is a dice with random value
     * @var Dice|null
     */
    public ?Dice $dice = null;

    /**
     * Optional. Message is a game, information about the game. More about games »
     * @var Game|null
     */
    public ?Game $game = null;

    /**
     * Optional. Message is a scheduled giveaway, information about the giveaway
     * @var Giveaway|null
     */
    public ?Giveaway $giveaway = null;

    /**
     * Optional. A giveaway with public winners was completed
     * @var GiveawayWinners|null
     */
    public ?GiveawayWinners $giveaway_winners = null;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     * @var Invoice|null
     */
    public ?Invoice $invoice = null;

    /**
     * Optional. Message is a shared location, information about the location
     * @var Location|null
     */
    public ?Location $location = null;

    /**
     * Optional. Message is a native poll, information about the poll
     * @var Poll|null
     */
    public ?Poll $poll = null;

    /**
     * Optional. Message is a venue, information about the venue
     * @var Venue|null
     */
    public ?Venue $venue = null;
}
