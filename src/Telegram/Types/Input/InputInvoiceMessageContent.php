<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\Payment\LabeledPrice;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of an
 * invoice message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputinvoicemessagecontent
 */
class InputInvoiceMessageContent
{
    /**
     * Product name, 1-32 characters
     * @var string $title
     */
    public $title;

    /**
     * Product description, 1-255 characters
     * @var string $description
     */
    public $description;

    /**
     * Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @var string $payload
     */
    public $payload;

    /**
     * Payment provider token, obtained via {@see https://t.me/botfather Botfather}
     * @var string $provider_token
     */
    public $provider_token;

    /**
     * Three-letter ISO 4217 currency code,
     * see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @var string $currency
     */
    public $currency;

    /**
     * Price breakdown, a list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus,
     * etc.)
     * @var LabeledPrice[] $prices
     */
    public $prices;

    /**
     * Optional. The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double).
     * For example, for a maximum tip of `US$ 1.45` pass `max_tip_amount = 145`.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json},
     * it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * Defaults to 0
     * @var integer $max_tip_amount
     */
    public $max_tip_amount;

    /**
     * Optional. An array of suggested amounts of tip in the smallest units of the currency
     * (integer, not float/double). At most 4 suggested tip amounts can be specified.
     * The suggested tip amounts must be positive, passed in a strictly increased order
     * and must not exceed max_tip_amount.
     * @var int[] $suggested_tip_amounts
     */
    public $suggested_tip_amounts;

    /**
     * Optional. An object for data about the invoice, which will be shared with the payment provider.
     * A detailed description of the required fields should be provided by the payment provider.
     * @var string $provider_data
     */
    public $provider_data;

    /**
     * Optional. URL of the product photo for the invoice.
     * Can be a photo of the goods or a marketing image for a service.
     * People like it better when they see what they are paying for.
     * @var string $photo_url
     */
    public $photo_url;

    /**
     * Optional. Photo size
     * @var int $photo_size
     */
    public $photo_size;

    /**
     * Optional. Photo width
     * @var int $photo_width
     */
    public $photo_width;

    /**
     * Optional. Photo height
     * @var int $photo_height
     */
    public $photo_height;

    /**
     * Optional. Pass True, if you require the user's full name to complete the order
     * @var bool $need_name
     */
    public $need_name;

    /**
     * Optional. Pass True, if you require the user's phone number to complete the order
     * @var bool $need_phone_number
     */
    public $need_phone_number;

    /**
     * Optional. Pass True, if you require the user's email address to complete the order
     * @var bool $need_email
     */
    public $need_email;

    /**
     * Optional. Pass True, if you require the user's shipping address to complete the order
     * @var bool $need_shipping_address
     */
    public $need_shipping_address;

    /**
     * Optional. Pass True, if user's phone number should be sent to provider
     * @var bool $send_phone_number_to_provider
     */
    public $send_phone_number_to_provider;

    /**
     * Optional. Pass True, if user's email address should be sent to provider
     * @var bool $send_email_to_provider
     */
    public $send_email_to_provider;

    /**
     * Optional. Pass True, if the final price depends on the shipping method
     * @var bool $is_flexible
     */
    public $is_flexible;
}
