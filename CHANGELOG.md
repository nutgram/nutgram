# Changelog

All notable changes to `nutgram` will be documented in this file.

## 3.7.3 - 2022-09-09

### What's Changed

- allow override low level call by @SergiX44 in https://github.com/nutgram/nutgram/pull/193

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.2...3.7.3

## 3.7.2 - 2022-09-02

### What's Changed

- switch to laravel serializable closure by @SergiX44 in https://github.com/nutgram/nutgram/pull/192

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.1...3.7.2

## 3.7.1 - 2022-08-23

### What's Changed

- ability to retrieve the current conversation from outside the context by @SergiX44 in https://github.com/nutgram/nutgram/pull/191

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.0...3.7.1

## 3.7.0 - 2022-08-12

### What's Changed

- move wordwrap to helper class by @SergiX44 in https://github.com/nutgram/nutgram/pull/187
- bot api 6.2 by @SergiX44 in https://github.com/nutgram/nutgram/pull/189

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.6.0...3.7.0

## 3.6.0 - 2022-08-01

### What's Changed

- Message chunk support by @Lukasss93 in https://github.com/nutgram/nutgram/pull/174
- Fix null token by @miki131 in https://github.com/nutgram/nutgram/pull/177
- Serializable instance by @SergiX44 in https://github.com/nutgram/nutgram/pull/172
- Fixed class name and namespace issue when creating command by @mkhab7 in https://github.com/nutgram/nutgram/pull/180
- Add nutgram:ide:generate command by @Lukasss93 in https://github.com/nutgram/nutgram/pull/181
- Raise psalm error level by @SergiX44 in https://github.com/nutgram/nutgram/pull/185
- support bot_id cache by @SergiX44 in https://github.com/nutgram/nutgram/pull/184

### New Contributors

- @miki131 made their first contribution in https://github.com/nutgram/nutgram/pull/177

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.5.1...3.6.0

## 3.5.1 - 2022-07-02

### Fixed

- Fix wrong `$clientOpt` merge in laravel mixins

## 3.5.0 - 2022-06-26

### Added

- Add Nutgram mixins for Laravel
- Add new Laravel command: `nutgram:make:command`
- Add new Laravel command: `nutgram:make:conversation`
- Add new Laravel command: `nutgram:make:conversation`
- Add new Laravel command: `nutgram:make:handler`
- Add new Laravel command: `nutgram:make:middleware`

## 3.4.0 - 2022-06-21

### Added

- Support for bot api 6.1

## 3.3.0 - 2022-06-20

### Added

- Add `local_path_transformer` config key

### Fixed

- Fixed `downloadFile` method when "is_local" config key is `true`
- Fixed missing phpdoc on `jsonSerialize` methods

## 3.2.1 - 2022-05-15

### Changed

- The `explanation_entities` field mapping is now optional.

## 3.2.0 - 2022-05-14

### Added

- Support for Telegram test environment
- Minor additions and fixes

### Fixed

- Serialization issue on the types

## 3.1.4 - 2022-05-12

### Changed

- Code improvements

## 3.1.3 - 2022-05-10

### Fixed

- Handling autowire of inline_message_id field

## 3.1.2 - 2022-04-26

### Fixed

- Fixed missing nullable fields
- Fixed wrong phpdoc on BaseType trait

## 3.1.1 - 2022-04-25

### Fixed

- Wrong json mapper namespace

## 3.1.0 - 2022-04-25

### Added

- Added a way to disable error handlers

### Changed

- Changed json mapper implementation

## 3.0.0 - 2022-04-17

### Added

- Support for bot api 6.0

## 2.1.1 - 2022-03-31

### Fixed

- Fix assertions with multipart requests

## 2.1 - 2022-03-20

### Added

- Added `copy` method to `Message` type
- Added `forward` method to `Message` type
- Added a new Laravel command: `nutgram:list`

### Changed

- Added date format to `last_error_date` field in `nutgram:hook:info` command

## 2.0 - 2022-03-14

### Added

- All types extend the `BaseType` class
- `Nutgram` and `BaseType` extends [Macroable](https://nutgram.dev/docs/usage/extend) class
- Added [testing system](https://nutgram.dev/docs/testing/introduction)
- Added helpers method to `Message` type: `delete()` and `editText()`

## 1.4.1 - 2022-02-21

### Fixed

- Fixed wrong handler with "animation" message

## 1.4.0 - 2022-02-18

### Added

- Webhook safe mode.

### Changed

- Replace service container implementation.

### Fixed

- Dependency conflict on Laravel 9.

## 1.3.0 - 2022-02-07

### Added

- Support for bot api 5.6/5.7.

## 1.2.0 - 2021-12-09

### Added

- Support for bot api 5.5.

## 1.1.1 - 2021-12-03

### Fixed

- Mapping issue with array of objects.

## 1.1.0 - 2021-11-30

### Added

- Guzzle client options on multipart requests.

## 1.0.0 - 2021-11-18

### Changed

- 1.0 stable!

## 0.16.0 - 2021-11-03

### Added

- Auto-inject callback_data for InlineMenus.
- Maximum connections options.
- By type exceptions handlers.

### Fixed

- Error with closing the menu.

## 0.15.10 - 2021-10-29

### Fixed

- Fix invalid file_id

## 0.15.9 - 2021-10-26

### Added

- InputFile object to upload files
- Method to return the full url of a file

### Fixed

- Fixed in memory streams uploads

## 0.15.8 - 2021-10-20

### Fixed

- Fix ReplyKeyboardMarkup serialize

## 0.15.7 - 2021-10-20

### Fixed

- Fix missing JsonSerializable to other keyboards

## 0.15.6 - 2021-10-17

### Fixed

- Error with type conflict

## 0.15.5 - 2021-10-16

### Fixed

- Error with type conflict

## 0.15.4 - 2021-10-10

### Fixed

- Fixed nullable token on Laravel provider

## 0.15.3 - 2021-10-10

### Fixed

- Error on laravel auto-discover

## 0.15.2 - 2021-10-07

### Fixed

- Fixed namespaces
- Fixed missing documentation

## 0.15.1 - 2021-10-03

### Fixed

- Fix wrong telegram.php route file
- Fix missing ip argument in nutgram:hook:set

## 0.15.0 - 2021-10-03

### Changed

- Refactor telegram types

## 0.14.1 - 2021-09-27

### Fixed

- Fix wrong ChatMember mapping

## 0.14.0 - 2021-09-26

### Changed

- Updated documentation
- Improved Laravel integration

### Fixed

- Inline menu error when updating the same messages

## 0.13.1 - 2021-09-26

### Fixed

- Reopen behaviour

## 0.13.0 - 2021-09-25

### Added

- Added conversation menu

## 0.12.0 - 2021-09-25

### Added

- Added default step to conversation
- Added `closing` method to conversation

## 0.11.0 - 2021-09-21

### Added

- Added new laravel command: `nutgram:run`
- Added new laravel command: `nutgram:register-commands`
- Added new laravel command: `nutgram:hook:info`
- Added new laravel command: `nutgram:hook:remove`
- Added new laravel command: `nutgram:hook:set`
- Added `isCommand` helper

### Changed

- Code quality improvements

## 0.10.0 - 2021-09-19

### Added

- Added support to command auto registration
- Added type validation to `onMessageType` method
- Added type validation to `fallbackOn` method

## 0.9.1 - 2021-09-17

### Changed

- Code quality improvements

### Fixed

- Fix missing subtype support

## 0.9.0 - 2021-07-26

### Added

- Update to Bot API 5.3

## 0.8.0 - 2021-05-06

### Added

- Added `uploadStickerFile` method

## 0.7.0 - 2021-04-26

### Changed

- Update to Bot API 5.2

## 0.6.2 - 2021-04-14

### Changed

- Updated documentation
- Improved sending files

## 0.6.1 - 2021-03-12

### Fixed

- Added missing user from `my_chat_member` and `chat_member` types in `getUser` method

## 0.6.0 - 2021-03-10

### Added

- Added `onMyChatMember` handler
- Added `onChatMember` handler
- Added `myChatMember` helper
- Added `chatMember` helper

### Changed

- Update to Bot API 5.1
- Updated documentation

## 0.5.1 - 2021-03-09

### Changed

- Updated documentation

### Fixed

- Fix check update type on resolveHandler method

## 0.5.0 - 2021-03-08

### Added

- Added helper methods to create keyboards
- Implemented download method
- Added IoC on mapped objects

### Changed

- Improved running mode

## 0.4.1 - 2021-03-05

### Changed

- Updated documentation and tests

## 0.4.0 - 2021-03-04

### Added

- Allow non-class based conversations
- Added documentation

### Changed

- Code quality improvements

## 0.3.6 - 2021-03-01

### Added

- Implemented typed messages handlers

## 0.3.5 - 2021-03-01

### Changed

- Improved Laravel integration

## 0.3.4 - 2021-02-26

### Changed

- Make mapping fail safe

## 0.3.3 - 2021-02-25

### Fixed

- Fixed send attachments

## 0.3.2 - 2021-02-24

### Removed

- Removed useless async call

## 0.3.1 - 2021-02-23

### Fixed

- Fixed api error on polling mode

## 0.3.0 - 2021-02-22

### Fixed

- Fixed typed handlers

## 0.2.4 - 2021-02-20

### Fixed

- Fix type mapping

## 0.2.3 - 2021-02-19

### Added

- Added method to get the current update

## 0.2.2 - 2021-02-18

### Fixed

- Fix double call to the handler

## 0.2.1 - 2021-02-18

### Changes

- Allow null response on some methods

## 0.2.0 - 2021-02-18

### Added

- Added some helpers methods

### Fixed

- Fix nullable conversion step
- Fix wrong methods return type

## 0.1.2 - 2021-02-17

### Fixed

- Check null before fetch conversation

## 0.1.1 - 2021-02-17

### Added

- Added missing methods

## 0.1 - 2021-02-17

### Changed

- Initial release
