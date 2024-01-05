# Changelog

All notable changes to `nutgram` will be documented in this file.

## 4.14.2 - 2024-01-05

### What's Changed

* Fix wrong property name in ReactionTypeCustomEmoji class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/641

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.14.1...4.14.2

## 4.14.1 - 2024-01-04

### What's Changed

* Fix missing underscore support to named parameters by @Lukasss93 in https://github.com/nutgram/nutgram/pull/638
* Fix missing make methods by @Lukasss93 in https://github.com/nutgram/nutgram/pull/639
* Fix missing enum case + Fix nullable message type by @Lukasss93 in https://github.com/nutgram/nutgram/pull/640

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.14.0...4.14.1

## 4.14.0 - 2023-12-30

#### What's Changed

* Update to Bot API 7.0 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/633

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.13.1...4.14.0

### ⚠️ Warning

The signature of the following methods has changed, if you don't use named parameters, remember to change the method calls before releasing to production:

- **copyMessage**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendMessage**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  - Added the `link_preview_options` parameter after the `disable_web_page_preview` and before the `disable_notification` parameter
  
- **editMessageText**
  
  - Added the `link_preview_options` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendPhoto**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendVideo**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendAnimation**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendAudio**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendDocument**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendSticker**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendVideoNote**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendVoice**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendLocation**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendVenue**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendContact**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendPoll**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendDice**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendInvoice**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendGame**
  
  - Added the `reply_parameters parameter` after the `allow_sending_without_reply` and before the `reply_markup` parameter
  
- **sendMediaGroup**
  
  - Added the `reply_parameters` parameter after the `allow_sending_without_reply` and before the `clientOpt` parameter
  

## 4.13.1 - 2023-12-25

### What's Changed

* fix update is null when falling the in catch case by @sergix44 in https://github.com/nutgram/nutgram/pull/632

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.13.0...4.13.1

## 4.13.0 - 2023-12-19

### What's Changed

* Fix regex for named parameters by @Lukasss93 in https://github.com/nutgram/nutgram/pull/628
* Add new where constraints by @Lukasss93 in https://github.com/nutgram/nutgram/pull/629

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.12.1...4.13.0

## 4.12.1 - 2023-12-01

### What's Changed

* Fix missing onUpdate handler + refactor handler structure by @Lukasss93 in https://github.com/nutgram/nutgram/pull/621

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.12.0...4.12.1

## 4.12.0 - 2023-11-30

### What's Changed

* Fix registerMyCommands with commands with optional parameters by @Lukasss93 in https://github.com/nutgram/nutgram/pull/619
* Add ability to manually pass additional parameters to conversations by @Lukasss93 in https://github.com/nutgram/nutgram/pull/620
* Resolve parameters in the default conversation step by @Lukasss93 in https://github.com/nutgram/nutgram/pull/620

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.11.2...4.12

## 4.11.2 - 2023-11-29

### What's Changed

* Refine user and chat matching by @Lukasss93 in https://github.com/nutgram/nutgram/pull/617

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.11.1...4.11.2

## 4.11.1 - 2023-11-23

### What's Changed

- Fix missing message handlers by @Lukasss93 in https://github.com/nutgram/nutgram/pull/613

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.11.0...4.11.1

## 4.11.0 - 2023-10-27

### What's Changed

- Refactor logging system by @Lukasss93 in https://github.com/nutgram/nutgram/pull/603

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.10.0...4.11.0

## 4.10.0 - 2023-10-03

### What's Changed

- Add where constraint by @Lukasss93 in https://github.com/nutgram/nutgram/pull/588

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.9.1...4.10.0

## 4.9.1 - 2023-09-29

### What's Changed

- Fix regex matching by @Lukasss93 in https://github.com/nutgram/nutgram/pull/584

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.9.0...4.9.1

## 4.9.0 - 2023-09-22

### What's Changed

- Fix missing support for underscores in bot command names when used with bot username set by @Lukasss93 in https://github.com/nutgram/nutgram/pull/578
- Add the ability to disable handler registration by @Lukasss93 in https://github.com/nutgram/nutgram/pull/579
- Update to Bot API 6.9 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/580

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.8.0...4.9.0

### ⚠️ Warning

The "promoteChatMember" signature has been changed, if you don't use named parameters, remember to change the method calls before releasing to production.

## 4.8.0 - 2023-09-20

### What's Changed

- Add onChosenInlineResultQuery handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/575
- Fix missing static make method and add support for ParseMode enum by @Lukasss93 in https://github.com/nutgram/nutgram/pull/573

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.7.0...4.8.0

## 4.7.0 - 2023-09-13

### What's Changed

- Add the ability to start conversations for specific user/chat by @Lukasss93 in https://github.com/nutgram/nutgram/pull/569

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.6.0...4.7.0

## 4.6.0 - 2023-09-08

### What's Changed

- Replace ip safe mode by @SergiX44 in https://github.com/nutgram/nutgram/pull/557
- Add PHP 8.3 to the GitHub Actions workflow by @Lukasss93 in https://github.com/nutgram/nutgram/pull/560
- Fix regression for sendMediaGroup by @Lukasss93 in https://github.com/nutgram/nutgram/pull/565
- Fix BUTTON_DATA_INVALID using inline menu by @SergiX44 in https://github.com/nutgram/nutgram/pull/561
- Add ValidatesWebData trait by @Lukasss93 in https://github.com/nutgram/nutgram/pull/562
- Fix chunked endpoints by @Lukasss93 in https://github.com/nutgram/nutgram/pull/553

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.5.3...4.6.0

## 4.5.3 - 2023-08-25

### What's Changed

- Do not try to serialize the delegate container by @SergiX44 in https://github.com/nutgram/nutgram/pull/549
- Fix inline or message chat guess by @SergiX44 in https://github.com/nutgram/nutgram/pull/551

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.5.2...4.5.3

## 4.5.2 - 2023-08-22

### What's Changed

- Fix wrong regex capture group by @Lukasss93 in https://github.com/nutgram/nutgram/pull/548

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.5.1...4.5.2

## 4.5.1 - 2023-08-20

### What's Changed

- Fix missing DI in Command class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/546

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.5.0...4.5.1

## 4.5.0 - 2023-08-19

### What's Changed

- Update to Bot Api 6.8 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/545

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.4.1...4.5.0

## 4.4.1 - 2023-08-17

### What's Changed

- improve polling running mode by @SergiX44 in https://github.com/nutgram/nutgram/pull/543

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.4.0...4.4.1

## 4.4.0 - 2023-08-08

### What's Changed

- Add throwable api error by @Lukasss93 in https://github.com/nutgram/nutgram/pull/533

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.3.2...4.4.0

## 4.3.2 - 2023-07-26

### What's Changed

- wip by @SergiX44 in https://github.com/nutgram/nutgram/pull/530
- Fix inability to use InputSticker object with multipart requests by @Lukasss93 in https://github.com/nutgram/nutgram/pull/528
- Fix missing enums by @Lukasss93 in https://github.com/nutgram/nutgram/pull/531

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.3.1...4.3.2

## 4.3.1 - 2023-07-20

### What's Changed

- Log errors in Webhook by @asanikovich in https://github.com/nutgram/nutgram/pull/523
- Fix missing boolean fields in requests by @Lukasss93 in https://github.com/nutgram/nutgram/pull/525

### New Contributors

- @asanikovich made their first contribution in https://github.com/nutgram/nutgram/pull/523

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.3.0...4.3.1

## 4.3.0 - 2023-07-17

### What's Changed

- Add tags + macroable to HandlerGroup class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/519
- invoke via container by @SergiX44 in https://github.com/nutgram/nutgram/pull/518
- [4.x] Add onInlineQueryText handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/522

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.2.0...4.3.0

## 4.2.0 - 2023-07-03

### What's Changed

- [4.x] Reply directly and give method as JSON payload in the reply by @Lukasss93 in https://github.com/nutgram/nutgram/pull/515

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.1.1...4.2.0

## 4.1.1 - 2023-07-03

### What's Changed

- Add tags + macroable to handler class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/514
- use container 2 by @SergiX44 in https://github.com/nutgram/nutgram/pull/517

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.1.0...4.1.1

## 4.1.0 - 2023-06-28

### What's Changed

- Fix missing json serialized objects by @Lukasss93 in https://github.com/nutgram/nutgram/pull/504
- Add assertSequence method to FakeNutgram by @Lukasss93 in https://github.com/nutgram/nutgram/pull/489
- remove abandoned league/container by @SergiX44 in https://github.com/nutgram/nutgram/pull/508
- allow extra non validated config by @SergiX44 in https://github.com/nutgram/nutgram/pull/510

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.0.2...4.1.0

## 3.20.2 - 2023-06-23

### What's Changed

- [3.x] Fix missing temp file deletion when using the mixin method by @Lukasss93 in https://github.com/nutgram/nutgram/pull/500

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.20.1...3.20.2

## 4.0.2 - 2023-06-23

### What's Changed

- running mode tests by @SergiX44 in https://github.com/nutgram/nutgram/pull/482
- simplify closemenu by @SergiX44 in https://github.com/nutgram/nutgram/pull/483
- Code refactoring by @Lukasss93 in https://github.com/nutgram/nutgram/pull/484
- Add supportukrainenow.org banner by @Lukasss93 in https://github.com/nutgram/nutgram/pull/493
- support http2 by @SergiX44 in https://github.com/nutgram/nutgram/pull/501

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.0.1...4.0.2

## 4.0.1 - 2023-06-05

### What's Changed

- Fixing UpdateType could not be converted to string error by @AntonLeontev in https://github.com/nutgram/nutgram/pull/478
- improve webhook handling by @SergiX44 in https://github.com/nutgram/nutgram/pull/480

### New Contributors

- @AntonLeontev made their first contribution in https://github.com/nutgram/nutgram/pull/478

**Full Changelog**: https://github.com/nutgram/nutgram/compare/4.0.0...4.0.1

## 4.0.0 - 2023-05-30

### What's Changed

#### ⚠️ Please check the [UPGRADING.md](https://nutgram.dev/docs/upgrading/from-3.x-to-4.x) file before upgrading to this major version!

- [4.x] Add Supported versions table by @Lukasss93 in https://github.com/nutgram/nutgram/pull/355
- [4.x] Remove deprecations by @Lukasss93 in https://github.com/nutgram/nutgram/pull/357
- [4.x] Bump PHP version from 8.0 to 8.2 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/356
- [4.x] Drop Laravel integration (it will be moved in another package) by @SergiX44 in https://github.com/nutgram/nutgram/pull/359
- [4.x] Attributes to Enums by @Lukasss93 in https://github.com/nutgram/nutgram/pull/362
- [4.x] Array_merge to spread by @Lukasss93 in https://github.com/nutgram/nutgram/pull/377
- [4.x] Use configuration class for additional settings instead of array by @SergiX44 in https://github.com/nutgram/nutgram/pull/365
- [4.x] Migrate phpunit.xml schema (PHPUnit 10.1 and Pest 2.5) by @Lukasss93 in https://github.com/nutgram/nutgram/pull/422
- [4.x] Drop custom objects by @Lukasss93 in https://github.com/nutgram/nutgram/pull/421
- [4.x] Chunked endpoints by @Lukasss93 in https://github.com/nutgram/nutgram/pull/429
- [4.x] Convert $opt array to named parameters by @SergiX44 in https://github.com/nutgram/nutgram/pull/433
- [4.x] Better abstract types integration by @Lukasss93 in https://github.com/nutgram/nutgram/pull/444
- [4.x] Fix inputfile usages by @Lukasss93 in https://github.com/nutgram/nutgram/pull/446
- [4.x] Add download method to Media types by @Lukasss93 in https://github.com/nutgram/nutgram/pull/447
- [4.x] New group syntax by @SergiX44 in https://github.com/nutgram/nutgram/pull/451
- [4.x] Fix InputFile inside InputMedia* classes by @Lukasss93 in https://github.com/nutgram/nutgram/pull/453
- Update readme by @Lukasss93 in https://github.com/nutgram/nutgram/pull/457
- [4.x] Fix type faker abstract resolver by @Lukasss93 in https://github.com/nutgram/nutgram/pull/461
- [4.x] Fix warning by @Lukasss93 in https://github.com/nutgram/nutgram/pull/466
- [4.x] Fix fakeDataFor for matrix type by @Lukasss93 in https://github.com/nutgram/nutgram/pull/462
- [4.x] Case sensitive pattern by @Lukasss93 in https://github.com/nutgram/nutgram/pull/465
- [4.x] Get current parameters for the current resolved handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/474
- Drop setCache method by @SergiX44 in https://github.com/nutgram/nutgram/pull/476
- Fake throws exception when the update is empty by @SergiX44 in https://github.com/nutgram/nutgram/pull/477

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.20.1...4.0.0

## 3.20.1 - 2023-05-23

### What's Changed

- Case insensitive onText for Cyrillic by @Tiamenti in https://github.com/nutgram/nutgram/pull/463

### New Contributors

- @Tiamenti made their first contribution in https://github.com/nutgram/nutgram/pull/463

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.20.0...3.20.1

## 3.20.0 - 2023-05-05

### What's Changed

- Apply fixes from StyleCI by @SergiX44 in https://github.com/nutgram/nutgram/pull/443
- [3.x] Add currentParameters method to obtain target handler parameters by @Lukasss93 in https://github.com/nutgram/nutgram/pull/442

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.19.0...3.20.0

## 3.19.0 - 2023-04-24

### What's Changed

- [3.x] Update to Bot Api 6.7 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/424

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.18.0...3.19.0

## 3.18.0 - 2023-04-16

### What's Changed

- Fix "$request" content in beforeApiRequest handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/417
- Simplify bot scope implementation by @SergiX44 in https://github.com/nutgram/nutgram/pull/420
- Command Scope Support by @Lukasss93 in https://github.com/nutgram/nutgram/pull/418

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.17.2...3.18.0

## 3.17.2 - 2023-04-03

### What's Changed

- Fix memory when using nested groups by @Lukasss93 in https://github.com/nutgram/nutgram/pull/414

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.17.1...3.17.2

## 3.17.1 - 2023-03-14

### What's Changed

- Remove "Illuminate\Testing\Assert" dependency to fix errors in symfony by @Lukasss93 in https://github.com/nutgram/nutgram/pull/394
- possible fix for #378 by @SergiX44 in https://github.com/nutgram/nutgram/pull/395
- Fix LoggerHandler.php by @Z3d0X in https://github.com/nutgram/nutgram/pull/388
- Fix multiple middlewares by @Lukasss93 in https://github.com/nutgram/nutgram/pull/397

### New Contributors

- @Z3d0X made their first contribution in https://github.com/nutgram/nutgram/pull/388

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.17.0...3.17.1

## 3.17.0 - 2023-03-13

### What's Changed

- Apply fixes from StyleCI by @SergiX44 in https://github.com/nutgram/nutgram/pull/393
- [3.x] Update to Bot Api 6.6 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/382

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.16.0...3.17.0

## 3.16.0 - 2023-03-08

### What's Changed

- [3.x] Add chat type helper methods by @Lukasss93 in https://github.com/nutgram/nutgram/pull/371
- [3.x] Fix missing items in MessageEntityTypes and PassportSources attributes by @Lukasss93 in https://github.com/nutgram/nutgram/pull/375
- [3.x] Redact token in ConnectException by @Lukasss93 in https://github.com/nutgram/nutgram/pull/373

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.15.3...3.16.0

## 3.15.3 - 2023-03-05

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.15.2...3.15.3

## 3.15.2 - 2023-02-28

### What's Changed

- Add ability to pass multiple global middleware by @Lukasss93 in https://github.com/nutgram/nutgram/pull/353
- Add missing onForumTopicEdited handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/354

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.15.1...3.15.2

## 3.15.1 - 2023-02-27

### What's Changed

- Fix regex groups in https://github.com/nutgram/nutgram/pull/350

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.15.0...3.15.1

## 3.15.0 - 2023-02-27

### What's Changed

- middleware grouping by @SergiX44 in https://github.com/nutgram/nutgram/pull/343
- allow same callback data for different callbacks for InlineMenu by @SergiX44 in https://github.com/nutgram/nutgram/pull/347

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.14.0...3.15.0

## 3.14.0 - 2023-02-25

### What's Changed

- rehydrate a fresh conversation post deserialization by @SergiX44 in https://github.com/nutgram/nutgram/pull/339

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.13.1...3.14.0

## 3.13.1 - 2023-02-18

### What's Changed

- resolve the conversation instance via container by @SergiX44 in https://github.com/nutgram/nutgram/pull/333

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.13.0...3.13.1

## 3.13.0 - 2023-02-18

### What's Changed

- symfony bundle support by @SergiX44 in https://github.com/nutgram/nutgram/pull/321
- add request response handler interceptors by @SergiX44 in https://github.com/nutgram/nutgram/pull/309
- Common user chat in tests by @Lukasss93 in https://github.com/nutgram/nutgram/pull/325

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.12.1...3.13.0

## 3.12.1 - 2023-02-09

### What's Changed

- fixes #314 by @SergiX44 in https://github.com/nutgram/nutgram/pull/319

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.12.0...3.12.1

## 3.12.0 - 2023-02-05

### What's Changed

- Update to Bot Api 6.5 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/318

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.11.2...3.12.0

## 3.11.2 - 2023-01-24

### What's Changed

- Fix conversation + split message enabled by @Lukasss93 in https://github.com/nutgram/nutgram/pull/310

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.11.1...3.11.2

## 3.11.0 - 2023-01-11

### What's Changed

- Fix missing ArrayType annotations in some types by @Lukasss93 in https://github.com/nutgram/nutgram/pull/284
- Fix generic types by @Lukasss93 in https://github.com/nutgram/nutgram/pull/285
- Fix logger (response content) by @Lukasss93 in https://github.com/nutgram/nutgram/pull/287
- Allow command registration as instances or classes by @SergiX44 in https://github.com/nutgram/nutgram/pull/289
- Add support for DateInterval to TTL + mock time for cache expiration by @Lukasss93 in https://github.com/nutgram/nutgram/pull/290
- Move command object/class registration to specific API call by @SergiX44 in https://github.com/nutgram/nutgram/pull/291
- Add support for Laravel 10 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/292

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.10.0...3.11.0

## 3.10.0 - 2022-12-31

### What's Changed

- Add Laravel logger by @Lukasss93 in https://github.com/nutgram/nutgram/pull/271
- Fix missing use cases inside getChat and setChat methods in Update class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/278
- Update to Bot Api 6.4 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/282

### New Contributors

- @ShNURoK42 made their first contribution in https://github.com/nutgram/nutgram/pull/274

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.9.0...3.10.0

## 3.9.0 - 2022-11-17

### What's Changed

- New handlers by @Lukasss93 in https://github.com/nutgram/nutgram/pull/267
- Fix umask #268 by @SergiX44 in https://github.com/nutgram/nutgram/pull/269

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.8.1...3.9.0

## 3.8.1 - 2022-11-16

### What's Changed

- Add parameters support to TelegramException by @Lukasss93 in https://github.com/nutgram/nutgram/pull/249
- Add more tests by @Lukasss93 in https://github.com/nutgram/nutgram/pull/254
- Add TTL support to setUserData and setGlobalData by @Lukasss93 in https://github.com/nutgram/nutgram/pull/255
- Fix invalid pattern capturing (wrong behaviour with same values) by @Lukasss93 in https://github.com/nutgram/nutgram/pull/260
- Fix missing bot instance inside objects by @Lukasss93 in https://github.com/nutgram/nutgram/pull/257
- Fix invalid dependency by @Lukasss93 in https://github.com/nutgram/nutgram/pull/261

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.8.0...3.8.1

## 3.8.0 - 2022-11-07

### What's Changed

- Bot API 6.3 by @Lukasss93 in https://github.com/nutgram/nutgram/pull/235
- Fix command parser by @Lukasss93 in https://github.com/nutgram/nutgram/pull/238

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.9...3.8.0

## 3.7.9 - 2022-11-03

### What's Changed

- Add php 8.2 support to php.yml by @Lukasss93 in https://github.com/nutgram/nutgram/pull/227
- Fix chatId type of BulkMessenger class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/232
- 2 Tests 2 Coverage by @Lukasss93 in https://github.com/nutgram/nutgram/pull/228

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.8...3.7.9

## 3.7.8 - 2022-10-17

### What's Changed

- inline menu return message by @SergiX44 in https://github.com/nutgram/nutgram/pull/211
- Add nutgram:logout command by @Lukasss93 in https://github.com/nutgram/nutgram/pull/208
- Add "JSON_UNESCAPED_UNICODE" to "dump" method by @Lukasss93 in https://github.com/nutgram/nutgram/pull/213
- Coverage support by @Lukasss93 in https://github.com/nutgram/nutgram/pull/214
- experimental bulk messenger by @SergiX44 in https://github.com/nutgram/nutgram/pull/210
- increase coverage by @SergiX44 in https://github.com/nutgram/nutgram/pull/217
- tests! tests! tests! by @Lukasss93 in https://github.com/nutgram/nutgram/pull/220

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.7...3.7.8

## 3.7.7 - 2022-09-22

### What's Changed

- Fix psalm array annotations by @Lukasss93 in https://github.com/nutgram/nutgram/pull/205
- before step hook by @SergiX44 in https://github.com/nutgram/nutgram/pull/207

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.6...3.7.7

## 3.7.6 - 2022-09-17

### What's Changed

- Add onPreCheckoutQueryPayload handler by @Lukasss93 in https://github.com/nutgram/nutgram/pull/198
- Logging by @Lukasss93 in https://github.com/nutgram/nutgram/pull/196
- Add onSuccessfulPayment + onSuccessfulPaymentPayload handlers by @Lukasss93 in https://github.com/nutgram/nutgram/pull/199
- Psalm array annotations by @Lukasss93 in https://github.com/nutgram/nutgram/pull/201
- Add skipGlobalMiddlewares method to Handler class by @Lukasss93 in https://github.com/nutgram/nutgram/pull/204

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.5...3.7.6

## 3.7.5 - 2022-09-11

### What's Changed

- Options for inline menu callback query by @SergiX44 in https://github.com/nutgram/nutgram/pull/197

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.4...3.7.5

## 3.7.4 - 2022-09-10

### What's Changed

- closing features by @SergiX44 in https://github.com/nutgram/nutgram/pull/194

**Full Changelog**: https://github.com/nutgram/nutgram/compare/3.7.3...3.7.4

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
