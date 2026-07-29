<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlock;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockAnchor;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockAnimation;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockAudio;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockBlockQuotation;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCollage;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockDetails;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockDivider;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockFooter;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockList;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockMap;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockMathematicalExpression;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockParagraph;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockPhoto;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockPreformatted;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockPullQuotation;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockSectionHeading;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockSlideshow;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockTable;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockThinking;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockVideo;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockVoiceNote;

#[Attribute(Attribute::TARGET_CLASS)]
class RichBlockResolver extends ConcreteResolver
{
    protected array $concretes = [
        RichBlockType::PARAGRAPH->value => RichBlockParagraph::class,
        RichBlockType::HEADING->value => RichBlockSectionHeading::class,
        RichBlockType::PRE->value => RichBlockPreformatted::class,
        RichBlockType::FOOTER->value => RichBlockFooter::class,
        RichBlockType::DIVIDER->value => RichBlockDivider::class,
        RichBlockType::MATHEMATICAL_EXPRESSION->value => RichBlockMathematicalExpression::class,
        RichBlockType::ANCHOR->value => RichBlockAnchor::class,
        RichBlockType::LIST->value => RichBlockList::class,
        RichBlockType::BLOCKQUOTE->value => RichBlockBlockQuotation::class,
        RichBlockType::PULLQUOTE->value => RichBlockPullQuotation::class,
        RichBlockType::COLLAGE->value => RichBlockCollage::class,
        RichBlockType::SLIDESHOW->value => RichBlockSlideshow::class,
        RichBlockType::TABLE->value => RichBlockTable::class,
        RichBlockType::DETAILS->value => RichBlockDetails::class,
        RichBlockType::MAP->value => RichBlockMap::class,
        RichBlockType::ANIMATION->value => RichBlockAnimation::class,
        RichBlockType::AUDIO->value => RichBlockAudio::class,
        RichBlockType::PHOTO->value => RichBlockPhoto::class,
        RichBlockType::VIDEO->value => RichBlockVideo::class,
        RichBlockType::VOICE_NOTE->value => RichBlockVoiceNote::class,
        RichBlockType::THINKING->value => RichBlockThinking::class,
    ];
    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class implements RichBlock {
        })::class;
    }
}
