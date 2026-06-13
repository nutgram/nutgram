<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

/**
 * This object represents a block in a rich formatted message. Currently, it can be any of the following types:
 * {@see RichBlockParagraph}
 * {@see RichBlockSectionHeading}
 * {@see RichBlockPreformatted}
 * {@see RichBlockFooter}
 * {@see RichBlockDivider}
 * {@see RichBlockMathematicalExpression}
 * {@see RichBlockAnchor}
 * {@see RichBlockList}
 * {@see RichBlockBlockQuotation}
 * {@see RichBlockPullQuotation}
 * {@see RichBlockCollage}
 * {@see RichBlockSlideshow}
 * {@see RichBlockTable}
 * {@see RichBlockDetails}
 * {@see RichBlockMap}
 * {@see RichBlockAnimation}
 * {@see RichBlockAudio}
 * {@see RichBlockPhoto}
 * {@see RichBlockVideo}
 * {@see RichBlockVoiceNote}
 * {@see RichBlockThinking}
 * @see https://core.telegram.org/bots/api#richblock
 */
interface RichBlock
{
    // nothing here, this interface is only for type hinting
}
