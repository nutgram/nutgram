# Changelog

All notable changes to `nutgram` will be documented in this file.

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
