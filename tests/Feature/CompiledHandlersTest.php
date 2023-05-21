<?php

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;

it('compiles closure handlers', function ($update) {
   $bot = Nutgram::fake($update, config: new Configuration(enableCompilation: true));

   $bot->onCommand('start', function () {
      //
   })->middleware(function () {

   });

   $bot->run();

   $cache = $bot->getGlobalData('handlers.cache');

   expect($cache)->not->toBeNull();
})->with('message');
