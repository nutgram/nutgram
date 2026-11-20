<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Checklist\Checklist;
use SergiX44\Nutgram\Telegram\Types\Game\Game;
use SergiX44\Nutgram\Telegram\Types\Giveaway\Giveaway;
use SergiX44\Nutgram\Telegram\Types\Giveaway\GiveawayWinners;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Location\Venue;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\Contact;
use SergiX44\Nutgram\Telegram\Types\Media\Dice;
use SergiX44\Nutgram\Telegram\Types\Media\Document;
use SergiX44\Nutgram\Telegram\Types\Media\LivePhoto;
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
use SergiX44\Nutgram\Telegram\Types\Widget\Widget;

/**
 * This object contains information about a message that is being replied to, which may come from another chat or forum topic.
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
class ExternalReplyInfo extends BaseType
{
    /**
     * Origin of the message replied to by the given message
     */
    public MessageOrigin $origin;

    /**
     * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
     */
    public ?Chat $chat = null;

    /**
     * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
     */
    public ?int $message_id = null;

    /**
     * Optional. Options used for link preview generation for the original message, if it is a text message
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    /**
     * Optional. Message is an animation, information about the animation
     */
    public ?Animation $animation = null;

    /**
     * Optional. Message is an audio file, information about the file
     */
    public ?Audio $audio = null;

    /**
     * Optional. Message is a general file, information about the file
     */
    public ?Document $document = null;

    /**
     * Optional. Message is a live photo, information about the live photo
     */
    public ?LivePhoto $live_photo = null;

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
     */
    public ?Sticker $sticker = null;

    /**
     * Optional. Message is a forwarded story
     */
    public ?Story $story = null;

    /**
     * Optional. Message is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * Optional. Message is a video note, information about the video message
     */
    public ?VideoNote $video_note = null;

    /**
     * Optional. Message is a voice message, information about the file
     */
    public ?Voice $voice = null;

    /**
     * Optional. Message is an HTML widget, information about the widget
     */
    public ?Widget $widget = null;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     */
    public ?bool $has_media_spoiler = null;

    /**
     * Optional. Message is a checklist
     */
    public ?Checklist $checklist = null;

    /**
     * Optional. Message is a shared contact, information about the contact
     */
    public ?Contact $contact = null;

    /**
     * Optional. Message is a dice with random value
     */
    public ?Dice $dice = null;

    /**
     * Optional. Message is a game, information about the game. More about games »
     */
    public ?Game $game = null;

    /**
     * Optional. Message is a scheduled giveaway, information about the giveaway
     */
    public ?Giveaway $giveaway = null;

    /**
     * Optional. A giveaway with public winners was completed
     */
    public ?GiveawayWinners $giveaway_winners = null;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     */
    public ?Invoice $invoice = null;

    /**
     * Optional. Message is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * Optional. Message is a native poll, information about the poll
     */
    public ?Poll $poll = null;

    /**
     * Optional. Message is a venue, information about the venue
     */
    public ?Venue $venue = null;
}
