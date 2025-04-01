<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMedia;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaPreview;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaVideo;

#[Attribute(Attribute::TARGET_CLASS)]
class PaidMediaResolver extends ConcreteResolver
{
    protected array $concretes = [
        PaidMediaType::PREVIEW->value => PaidMediaPreview::class,
        PaidMediaType::PHOTO->value => PaidMediaPhoto::class,
        PaidMediaType::VIDEO->value => PaidMediaVideo::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends PaidMedia {
        })::class;
    }
}
