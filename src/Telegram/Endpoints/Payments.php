<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Payment\LabeledPrice;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingOption;

/**
 * Trait Payments
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Payments
{
    /**
     * Use this method to send invoices.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendinvoice
     * @param string $title Product name, 1-32 characters
     * @param string $description Product description, 1-255 characters
     * @param string $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @param string $provider_token Payment provider token, obtained via {@see https://t.me/botfather @BotFather}
     * @param string $currency Three-letter ISO 4217 currency code, see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @param LabeledPrice[] $prices Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $max_tip_amount The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0
     * @param int[]|null $suggested_tip_amounts A JSON-serialized array of suggested amounts of tips in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
     * @param string|null $start_parameter Unique deep-linking parameter. If left empty, forwarded copies of the sent message will have a Pay button, allowing multiple users to pay directly from the forwarded message, using the same invoice. If non-empty, forwarded copies of the sent message will have a URL button with a deep link to the bot (instead of a Pay button), with the value used as the start parameter
     * @param string|null $provider_data JSON-serialized data about the invoice, which will be shared with the payment provider. A detailed description of required fields should be provided by the payment provider.
     * @param string|null $photo_url URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
     * @param int|null $photo_size Photo size in bytes
     * @param int|null $photo_width Photo width
     * @param int|null $photo_height Photo height
     * @param bool|null $need_name Pass True if you require the user's full name to complete the order
     * @param bool|null $need_phone_number Pass True if you require the user's phone number to complete the order
     * @param bool|null $need_email Pass True if you require the user's email address to complete the order
     * @param bool|null $need_shipping_address Pass True if you require the user's shipping address to complete the order
     * @param bool|null $send_phone_number_to_provider Pass True if the user's phone number should be sent to provider
     * @param bool|null $send_email_to_provider Pass True if the user's email address should be sent to provider
     * @param bool|null $is_flexible Pass True if the final price depends on the shipping method
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}. If empty, one 'Pay total price' button will be shown. If not empty, the first button must be a Pay button.
     * @return Message|null
     */
    public function sendInvoice(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?int $max_tip_amount = null,
        ?array $suggested_tip_amounts = null,
        ?string $start_parameter = null,
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
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): ?Message {
        $parameters = get_defined_vars();
        $parameters['prices'] = json_encode($prices, JSON_THROW_ON_ERROR);
        return $this->prepareAndSendRequest(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to create a link for an invoice.
     * Returns the created invoice link as String on success.
     * @see https://core.telegram.org/bots/api#createinvoicelink
     * @param string $title Product name, 1-32 characters
     * @param string $description Product description, 1-255 characters
     * @param string $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @param string $provider_token Payment provider token, obtained via {@see https://t.me/botfather BotFather}
     * @param string $currency Three-letter ISO 4217 currency code, see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @param LabeledPrice[] $prices Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @param int|null $max_tip_amount The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0
     * @param int[]|null $suggested_tip_amounts A JSON-serialized array of suggested amounts of tips in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
     * @param string|null $provider_data JSON-serialized data about the invoice, which will be shared with the payment provider. A detailed description of required fields should be provided by the payment provider.
     * @param string|null $photo_url URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service.
     * @param int|null $photo_size Photo size in bytes
     * @param int|null $photo_width Photo width
     * @param int|null $photo_height Photo height
     * @param bool|null $need_name Pass True if you require the user's full name to complete the order
     * @param bool|null $need_phone_number Pass True if you require the user's phone number to complete the order
     * @param bool|null $need_email Pass True if you require the user's email address to complete the order
     * @param bool|null $need_shipping_address Pass True if you require the user's shipping address to complete the order
     * @param bool|null $send_phone_number_to_provider Pass True if the user's phone number should be sent to the provider
     * @param bool|null $send_email_to_provider Pass True if the user's email address should be sent to the provider
     * @param bool|null $is_flexible Pass True if the final price depends on the shipping method
     * @return string|null
     */
    public function createInvoiceLink(
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
    ): ?string {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars());
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API will send an {@see https://core.telegram.org/bots/api#update Update} with a shipping_query field to the bot.
     * Use this method to reply to shipping queries.
     * On success, True is returned.
     * @see https://core.telegram.org/bots/api#answershippingquery
     * @param bool $ok Pass True if delivery to the specified address is possible and False if there are any problems (for example, if delivery to the specified address is not possible)
     * @param string|null $shipping_query_id Unique identifier for the query to be answered
     * @param ShippingOption[]|null $shipping_options Required if ok is True. A JSON-serialized array of available shipping options.
     * @param string|null $error_message Required if ok is False. Error message in human readable form that explains why it is impossible to complete the order (e.g. "Sorry, delivery to your desired address is unavailable'). Telegram will display this message to the user.
     * @return bool|null
     */
    public function answerShippingQuery(
        bool $ok,
        ?string $shipping_query_id = null,
        ?array $shipping_options = null,
        ?string $error_message = null,
    ): ?bool {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars());
    }

    /**
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation in the form of an {@see https://core.telegram.org/bots/api#update Update} with the field pre_checkout_query.
     * Use this method to respond to such pre-checkout queries.
     * On success, True is returned.
     * Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query was sent.
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     * @param bool $ok Specify True if everything is alright (goods are available, etc.) and the bot is ready to proceed with the order. Use False if there are any problems.
     * @param string|null $pre_checkout_query_id Unique identifier for the query to be answered
     * @param string|null $error_message Required if ok is False. Error message in human readable form that explains the reason for failure to proceed with the checkout (e.g. "Sorry, somebody just bought the last of our amazing black T-shirts while you were busy filling out your payment details. Please choose a different color or garment!"). Telegram will display this message to the user.
     * @return bool|null
     */
    public function answerPreCheckoutQuery(
        bool $ok,
        ?string $pre_checkout_query_id = null,
        ?string $error_message = null,
    ): ?bool {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars());
    }
}
