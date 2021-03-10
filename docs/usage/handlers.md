---
sort: 6
---

# Handlers

## Concept

The framework provides to you a nice API event-like to handling incoming updates:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onMessage(function (Nutgram $bot) {
    $bot->sendMessage('You sent a message!');
});

$bot->run();
```

Every `->on*` handler is called based on the update type defined
in [Telegram's update object](https://core.telegram.org/bots/api#update), there are also some specific handlers, which
may respond based on specific patterns or types of messages.

As you can also see from the example above, some required parameters (like the `chat_id`) can be **omitted**, while the
bot is in the context of managing an update, so those fields **are automatically extracted from the current update**.

Of course, **you can override them at any time**, simply by specifying them in the `$opt` array.

## Available Handlers

Here a full list of all the handler that listens to specific type of updates:

| Handler Method | Type | Description |
| --- | --- | --- |
| `onCommand(string $command, $callable)` | **Specific** | Handles text messages that begin with `/`.<br>Automatically parses commands like `cmd@botname`. | 
| `onText(string $pattern, $callable)` | **Specific** |  Handles text messages that match the given pattern (regex or parameters). | 
| `onMessageType(string $type, $callable)` | **Specific** |  Handles messages defined by type. |
| `onCallbackQueryData(string $pattern, $callable)` | **Specific** |  Handles callback query with a specific pattern, similar to `onText`. |
| `onMessage($callable)` | **Generic** |  Handles any incoming message. | 
| `onCallbackQuery($callable)` | **Generic** |  Handles any incoming callback query. |  
| `onEditedMessage($callable)` | **Generic** |  Handles any incoming edited message. | 
| `onChannelPost($callable)` | **Generic** |  Handles any message posted in a channel where the bot is administrator. | 
| `onEditedChannelPost($callable)` | **Generic** |  Handles any message edited in a channel where the bot is administrator. | 
| `onInlineQuery($callable)` | **Generic** |  Handles any incoming inline query. | 
| `onChosenInlineResult($callable)` | **Generic** |  Handles any incoming chosen inline result. | 
| `onShippingQuery($callable)` | **Generic** |  Handles any incoming shipping query. | 
| `onPreCheckoutQuery($callable)` | **Generic** |  Handles any incoming pre checkout query. | 
| `onPoll($callable)` | **Generic** |  Handles any incoming poll. | 
| `onPollAnswer($callable)` | **Generic** |  Handles any incoming poll answer. | 
| `onMyChatMember($callable)` | **Generic** |  Handles any chat member when updated. | 
| `onChatMember($callable)` | **Generic** |  Handles any chat member in other chats when updated. | 
| `onException($callable)` | **Special** |  This handler will be called whenever the handling of an update throws an exception, if undefined the exception will not be caught.<br>Check the next paragraph for more details. | 
| `onApiError($callable)` | **Special** |  This handler will be called every time a call to Telegram's api fails, if undefined the exception will not be caught.<br>Check the next paragraph for more details. | 
| `fallback($callable)` | **Special** |  This handler if defined will be called if no handler, specific or generic, has been found for the current update. | 
| `fallbackOn(string $type, $callable)` | **Special** |  This handler has the same behavior as the previous one, but allows you to put a filter on the type of updates it can handle. | 

## Specific & Special Handlers

### `onCommand`

It's possible to handle to specific commands, also with named parameters:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

// Called when a message contains the command "/start someParameter"
$bot->onCommand('start {parameter}', function (Nutgram $bot, $parameter) {
    $bot->sendMessage("The parameter is {$parameter}");
});

// Called on command "/help"
$bot->onCommand('help', function (Nutgram $bot) {
    $bot->sendMessage('Help me!');
});

$bot->run();
```

### `onText`

For text messages, is possible also put parameters to match a regex, or to match part of text:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

// ex. called when a message contains "My name is Mario"
$bot->onText('My name is {name}', function (Nutgram $bot, $name) {
    $bot->sendMessage("Hi {$name}");
});

// ex. called when a message contains "I want 6 pizzas"
$bot->onText('I want ([0-9]+) pizzas', function (Nutgram $bot, $n) {
    $bot->sendMessage("You will get {$n} pizzas!");
});

$bot->onText('I want ([0-9]+) portions of (pizza|cake)', function (Nutgram $bot, $amount, $dish) {
    $bot->sendMessage("You will get {$amount} portions of {$dish}!");
});

$bot->run();
```

### `onMessageType`

It's like the `onMessage` handler, but you can specify to which type of message you should handle:

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;

$bot = new Nutgram($_ENV['TOKEN']);

// Called only when you send a photo
$bot->onMessageType(MessageTypes::PHOTO, function (Nutgram $bot) {
    $photos = $bot->message()->photo;
    $bot->sendMessage('Nice pic!');
});

// Called only when you send an audio file
$bot->onMessageType(MessageTypes::AUDIO, function (Nutgram $bot) {
    $audio = $bot->message()->audio;
    $bot->sendMessage('I love this song!');
});

$bot->run();
```

You can see all the constants, in
the [MessageTypes::class](https://github.com/SergiX44/Nutgram/blob/master/src/Telegram/Attributes/MessageTypes.php).

### `onCallbackQueryData`

It's like the `onText` handler, but you can specify to which `data` contained in CallbackQuery to handle:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Choose an option:', [
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'One', 'callback_data' => 'one'],
                    ['text' => 'Two', 'callback_data' => 'two'],
                    ['text' => 'Cancel', 'callback_data' => 'cancel'],
                ],
            ],
        ])
    ]);
});

$bot->onCallbackQueryData('one|two', function (Nutgram $bot) {
    $bot->sendMessage('Nice!');
});

$bot->onCallbackQueryData('cancel', function (Nutgram $bot) {
    $bot->sendMessage('Canceled!');
});

$bot->run();
```

### `fallback`

This handler, if defined, will be called every time an `Update` will not match any other defined handler: 

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

// But the user send something else than /start
$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Started!');
});

$bot->fallback(function (Nutgram $bot) {
    $bot->sendMessage('Sorry, I don\'t understand.');
});

$bot->run();
```

### `fallbackOn`

This has the same behaviour of the `fallback`, but allow you to define handlers based on the `Update` type:

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

$bot = new Nutgram($_ENV['TOKEN']);

// define some handlers ...

// Called only for unmatched callback queries
$bot->fallbackOn(UpdateTypes::CALLBACK_QUERY, function (Nutgram $bot) {
    $bot->answerCallbackQuery();
    $bot->editMessageReplyMarkup([/* ... */]);
});

// Called only for unmatched messages
$bot->fallbackOn(UpdateTypes::MESSAGE, function (Nutgram $bot) {
    $bot->sendMessage('Sorry, I don\'t understand.');
});

$bot->run();
```

You can see all the constants, in
the [UpdateTypes::class](https://github.com/SergiX44/Nutgram/blob/master/src/Telegram/Attributes/UpdateTypes.php).

### `onException`

This handler, if defined, will be called if something on your other handlers goes wrong, passing the `$exception` as 
second argument:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

// define some handlers ...

// and exception is thrown...
$bot->onMessage(function (Nutgram $bot) {
    // do stuff
    throw new Exception('Oh no!');
});

// ... and passed to the exception handler
$bot->onException(function (Nutgram $bot, \Throwable $exception) {
    echo $exception->getMessage(); // Oh no!
    error_log($exception);
    $bot->sendMessage('Whoops!');
});

$bot->run();
```

### `onApiError`

The same concept of the `onException`, but for outgoing requests:

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onMessage(function (Nutgram $bot) {
    $bot->sendMessage('Invalid call!', ['chat_id' => null]);
});

$bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
    echo $exception->getMessage(); // TelegramException: ...
    error_log($exception);
});

$bot->run();
```

## OOP

So far you have seen handlers defined only as closures. But the framework, any definition that accepts a `$callable`, also
accepts a class-method definition, or invokable classes, like this:

```php
use SergiX44\Nutgram\Nutgram;

class MyCommand {

    public function __invoke(Nutgram $bot, $param) 
    {
      //do stuff
    }
}
```

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('start {param}', MyCommand::class);

$bot->run();
```

## Update Helpers

When dealing with updates, sometimes you may need to access data that is nested in the update structure, which can be
tedious and produce *a lot* of boilerplate, since the same objects can often be nested in other objects, depending on
the type of update. For this reason, the framework provides a number of **support methods to quickly access the most
used data, no matter the update type**, like this:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('help', function (Nutgram $bot) {    
    // Get the Message object
    $bot->message();
    
    // Access the Chat object
    $bot->chat();
});

$bot->onCommand('my_chat', function (Nutgram $bot) {    
    $bot->sendMessage('Your chat id is ' . $bot->chatId());
});

$bot->run();
```

### Available helpers

| Method | Return type | Description
| --- | --- | --- |
| `update()` | `?Update` | The current `Update` object. |
| `chatId()` | `?int` | The current `chat_id` if available, `null` otherwise. |
| `chat()` | `?Chat` | The current `Chat` if available, `null` otherwise. |
| `userId()` | `?int` | The current `from`.`id` if available, `null` otherwise. |
| `user()` | `?User` | The current `User` (`from` Telegram's object) if available, `null` otherwise. |
| `messageId()` | `?int` | The current `message`.`message_id` if available, `null` otherwise. |
| `message()` | `?Message` | The current `Message` if available, `null` otherwise. |
| `isCallbackQuery()` | `bool` | If the current update contains a `callback_query`. |
| `callbackQuery()` | `?CallbackQuery` | The current `CallbackQuery` if available, `null` otherwise. |
| `isInlineQuery()` | `bool` | If the current update contains an `inline_query`. |
| `inlineQuery()` | `?InlineQuery` | The current `InlineQuery` if available, `null` otherwise. |
| `chosenInlineResult()` | `?ChosenInlineResult` | The current `ChosenInlineResult` if available, `null` otherwise. |
| `shippingQuery()` | `?ShippingQuery` | The current `ShippingQuery` if available, `null` otherwise. |
| `isPreCheckoutQuery()` | `bool` | If the current update contains a `pre_checkout_query`. |
| `preCheckoutQuery()` | `?PreCheckoutQuery` | The current `PreCheckoutQuery` if available, `null` otherwise. |
| `poll()` | `?Poll` | The current `Poll` if available, `null` otherwise. |
| `pollAnswer()` | `?PollAnswer` | The current `PollAnswer` if available, `null` otherwise. |
| `isMyChatMember()` | `bool` | If the current `ChatMemberUpdated` is in the `my_chat_member`. |
| `chatMember()` | `?ChatMemberUpdated` | The current `ChatMemberUpdated` if available, `null` otherwise. |

## Persisting data

The framework gives you the ability to store data based on the update context: you can store data as **globally**
or **per-user**:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->setGlobalData('mykey', 'Hi!');
$bot->setUserData('mykey', 'Ciao!', $userId);

$value = $bot->getGlobalData('mykey'); // Hi!
$value = $bot->getUserData('mykey', $userId); // Ciao!

// when used inside a context, the $userId can be omitted.
$bot->onCommand('help', function (Nutgram $bot) {
    $bot->setUserData('mykey', 'called help!');
    $value = $bot->getUserData('mykey'); // called help!
});

$bot->run();
```

```tip
If you need to persist data on disk, be sure to choose an appropriate cache adapter!
```

### Available methods

| Method | Return type |
| --- | --- |
| `getGlobalData($key, $default = null)` | The data associated to the `$key`, if null `$default` is returned. |
| `setGlobalData($key, $value)` | `bool` |
| `deleteGlobalData($key)` | `bool` |
| `getUserData($key, ?int $userId = null, $default = null)` | The data associated to the `$key`, if null `$default` is returned. |
| `setUserData($key, $value, ?int $userId = null)` | `bool` |
| `deleteUserData($key, ?int $userId = null)` | `bool` |
