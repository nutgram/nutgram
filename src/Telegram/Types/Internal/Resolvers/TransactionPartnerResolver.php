<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartner;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerAffiliateProgram;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerChat;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerFragment;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerOther;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerTelegramAds;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerTelegramApi;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerUser;

#[Attribute(Attribute::TARGET_CLASS)]
class TransactionPartnerResolver extends ConcreteResolver
{
    protected array $concretes = [
        TransactionPartnerType::FRAGMENT->value => TransactionPartnerFragment::class,
        TransactionPartnerType::USER->value => TransactionPartnerUser::class,
        TransactionPartnerType::CHAT->value => TransactionPartnerChat::class,
        TransactionPartnerType::AFFILIATE_PROGRAM->value => TransactionPartnerAffiliateProgram::class,
        TransactionPartnerType::TELEGRAM_ADS->value => TransactionPartnerTelegramAds::class,
        TransactionPartnerType::TELEGRAM_API->value => TransactionPartnerTelegramApi::class,
        TransactionPartnerType::OTHER->value => TransactionPartnerOther::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends TransactionPartner {
        })::class;
    }
}
