<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\Payment\LabeledPrice;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of an invoice message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputinvoicemessagecontent
 */
class InputInvoiceMessageContent extends InputMessageContent
{
    /** Product name, 1-32 characters */
    public string $title;

    /** Product description, 1-255 characters */
    public string $description;

    /**
     * Bot-defined invoice payload, 1-128 bytes.
     * This will not be displayed to the user, use for your internal processes.
     */
    public string $payload;

    /**
     * Optional.
     * Payment provider token, obtained via {@see https://t.me/botfather @BotFather}.
     * Pass an empty string for payments in {@see https://t.me/BotNews/90 Telegram Stars}.
     */
    public ?string $provider_token = null;

    /**
     * Three-letter ISO 4217 currency code, see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}.
     * Pass “XTR” for payments in {@see https://t.me/BotNews/90 Telegram Stars}.
     */
    public string $currency;

    /**
     * Price breakdown, a JSON-serialized list of components (e.g.
     * product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @var LabeledPrice[] $prices
     */
    #[ArrayType(LabeledPrice::class)]
    public array $prices;

    /**
     * Optional.
     * The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double).
     * For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * Defaults to 0
     */
    public ?int $max_tip_amount = null;

    /**
     * Optional.
     * A JSON-serialized array of suggested amounts of tip in the smallest units of the currency (integer, not float/double).
     * At most 4 suggested tip amounts can be specified.
     * The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
     * @var int[]|null $suggested_tip_amounts
     */
    public ?array $suggested_tip_amounts = null;

    /**
     * Optional.
     * A JSON-serialized object for data about the invoice, which will be shared with the payment provider.
     * A detailed description of the required fields should be provided by the payment provider.
     */
    public ?string $provider_data = null;

    /**
     * Optional.
     * URL of the product photo for the invoice.
     * Can be a photo of the goods or a marketing image for a service.
     */
    public ?string $photo_url = null;

    /**
     * Optional.
     * Photo size in bytes
     */
    public ?int $photo_size = null;

    /**
     * Optional.
     * Photo width
     */
    public ?int $photo_width = null;

    /**
     * Optional.
     * Photo height
     */
    public ?int $photo_height = null;

    /**
     * Optional.
     * Pass True if you require the user's full name to complete the order
     */
    public ?bool $need_name = null;

    /**
     * Optional.
     * Pass True if you require the user's phone number to complete the order
     */
    public ?bool $need_phone_number = null;

    /**
     * Optional.
     * Pass True if you require the user's email address to complete the order
     */
    public ?bool $need_email = null;

    /**
     * Optional.
     * Pass True if you require the user's shipping address to complete the order
     */
    public ?bool $need_shipping_address = null;

    /**
     * Optional.
     * Pass True if the user's phone number should be sent to provider
     */
    public ?bool $send_phone_number_to_provider = null;

    /**
     * Optional.
     * Pass True if the user's email address should be sent to provider
     */
    public ?bool $send_email_to_provider = null;

    /**
     * Optional.
     * Pass True if the final price depends on the shipping method
     */
    public ?bool $is_flexible = null;

    public function __construct(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        ?int $max_tip_amount = null,
        ?array $suggested_tip_amounts = null,
        ?string $provider_data = null,
        ?string $photo_url = null,
        ?int $photo_size = null,
        ?int $photo_width = null,
        ?int $photo_height = null,
        ?bool $need_name = null,
        ?bool $need_phone_number = null,
        ?bool $need_email = null,
        ?bool $need_shipping_address = null,
        ?bool $send_phone_number_to_provider = null,
        ?bool $send_email_to_provider = null,
        ?bool $is_flexible = null,
    ) {
        parent::__construct();
        $this->title = $title;
        $this->description = $description;
        $this->payload = $payload;
        $this->provider_token = $provider_token;
        $this->currency = $currency;
        $this->prices = $prices;
        $this->max_tip_amount = $max_tip_amount;
        $this->suggested_tip_amounts = $suggested_tip_amounts;
        $this->provider_data = $provider_data;
        $this->photo_url = $photo_url;
        $this->photo_size = $photo_size;
        $this->photo_width = $photo_width;
        $this->photo_height = $photo_height;
        $this->need_name = $need_name;
        $this->need_phone_number = $need_phone_number;
        $this->need_email = $need_email;
        $this->need_shipping_address = $need_shipping_address;
        $this->send_phone_number_to_provider = $send_phone_number_to_provider;
        $this->send_email_to_provider = $send_email_to_provider;
        $this->is_flexible = $is_flexible;
    }

    public static function make(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        ?int $max_tip_amount = null,
        ?array $suggested_tip_amounts = null,
        ?string $provider_data = null,
        ?string $photo_url = null,
        ?int $photo_size = null,
        ?int $photo_width = null,
        ?int $photo_height = null,
        ?bool $need_name = null,
        ?bool $need_phone_number = null,
        ?bool $need_email = null,
        ?bool $need_shipping_address = null,
        ?bool $send_phone_number_to_provider = null,
        ?bool $send_email_to_provider = null,
        ?bool $is_flexible = null,
    ): self {
        return new self(
            title: $title,
            description: $description,
            payload: $payload,
            provider_token: $provider_token,
            currency: $currency,
            prices: $prices,
            max_tip_amount: $max_tip_amount,
            suggested_tip_amounts: $suggested_tip_amounts,
            provider_data: $provider_data,
            photo_url: $photo_url,
            photo_size: $photo_size,
            photo_width: $photo_width,
            photo_height: $photo_height,
            need_name: $need_name,
            need_phone_number: $need_phone_number,
            need_email: $need_email,
            need_shipping_address: $need_shipping_address,
            send_phone_number_to_provider: $send_phone_number_to_provider,
            send_email_to_provider: $send_email_to_provider,
            is_flexible: $is_flexible,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'title' => $this->title,
            'description' => $this->description,
            'payload' => $this->payload,
            'provider_token' => $this->provider_token ?: null,
            'currency' => $this->currency,
            'prices' => $this->prices,
            'max_tip_amount' => $this->max_tip_amount,
            'suggested_tip_amounts' => $this->suggested_tip_amounts,
            'provider_data' => $this->provider_data,
            'photo_url' => $this->photo_url,
            'photo_size' => $this->photo_size,
            'photo_width' => $this->photo_width,
            'photo_height' => $this->photo_height,
            'need_name' => $this->need_name,
            'need_phone_number' => $this->need_phone_number,
            'need_email' => $this->need_email,
            'need_shipping_address' => $this->need_shipping_address,
            'send_phone_number_to_provider' => $this->send_phone_number_to_provider,
            'send_email_to_provider' => $this->send_email_to_provider,
            'is_flexible' => $this->is_flexible,
        ]);
    }
}
