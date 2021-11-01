<?php

use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;

it('calls the message handler', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'A';
    });

    $bot->run();

    expect($test)->toBe('A');
})->with('message');

it('calls the message handler with a middleware', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'B';
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'A';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('AB');
})->with('message');

it('calls the message handler with multiple middlewares', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->middleware(function ($bot, $next) use (&$test) {
        $test .= 'A';
        $next($bot);
    });

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'D';
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'C';
        $next($bot);
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'B';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('ABCD');
})->with('message');

it('calls the fallback if not match any handler', function ($update) {
    $bot = getInstance($update);

    $bot->onText('Cia', function () {
        throw new Exception();
    });

    $bot->fallback(function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('message');

it('calls the specific fallback and not the general one if not match any handler', function ($update) {
    $bot = getInstance($update);

    $bot->onText('Cia', function () {
        throw new Exception();
    });

    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->fallbackOn(\SergiX44\Nutgram\Telegram\Attributes\UpdateTypes::MESSAGE, function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('message');

it('calls the right handler and no the fallback', function ($update) {
    $bot = getInstance($update);

    $bot->onText('Ciao', function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->fallbackOn(\SergiX44\Nutgram\Telegram\Attributes\UpdateTypes::MESSAGE, function ($bot) {
        throw new Exception();
    });

    $bot->run();
})->with('message');

it('calls the right handler and no the generic one', function ($update) {
    $bot = getInstance($update);

    $bot->onText('Ciao', function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });

    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->run();
})->with('message');

it('calls the right on command', function ($update) {
    $bot = getInstance($update);

    $bot->onCommand('start', function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->onCommand('end', function ($bot) {
        throw new Exception();
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });

    $bot->run();
})->with('command_message');

it('parse callback queries', function ($update) {
    $bot = getInstance($update);

    $bot->onCallbackQuery(function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });


    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->run();
})->with('callback_query');

it('parse callback queries with specific data', function ($update) {
    $bot = getInstance($update);

    $bot->onCallbackQueryData('thedata', function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });


    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->run();
})->with('callback_query');

it('calls the exception handler', function ($update) {
    $bot = getInstance($update);

    $bot->onCallbackQueryData('thedata', function ($bot) {
        throw new RuntimeException('error');
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });


    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->onException(function ($bot, $e) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
        expect($e)->toBeInstanceOf(RuntimeException::class);
        expect($e->getMessage())->toBe('error');
    });

    $bot->run();
})->with('callback_query');

it('calls the specific exception handler', function ($update) {
    $bot = getInstance($update);

    $bot->onCallbackQueryData('thedata', function ($bot) {
        throw new RuntimeException('error');
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });


    $bot->fallback(function ($bot) {
        throw new Exception();
    });

    $bot->onException(function ($bot, $e) {
        throw new Exception();
    });

    $bot->onException(RuntimeException::class, function ($bot, $e) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
        expect($e)->toBeInstanceOf(RuntimeException::class);
        expect($e->getMessage())->toBe('error');
    });

    $bot->run();
})->with('callback_query');

it('calls on edited message', function ($update) {
    $bot = getInstance($update);

    $bot->onCallbackQueryData('thedata', function ($bot) {
        throw new Exception();
    });

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });

    $bot->onEditedMessage(function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('edited_message');

it('call the typed message handler', function ($update) {
    $bot = getInstance($update);

    $bot->onMessage(function ($bot) {
        throw new Exception();
    });

    $bot->onMessageType(MessageTypes::PHOTO, function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('photo');

it('calls the typed message handler: text', function ($update) {
    $bot = getInstance($update);

    $bot->onMessageType(MessageTypes::TEXT, function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('text');

it('calls the onMessageTypeText handler and onText handlers', function ($update) {
    $bot = getInstance($update);

    $bot->onMessageType(MessageTypes::TEXT, function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->onText('.*', function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('text');

it('the catch all handler text not called for media', function ($update) {
    $bot = getInstance($update);

    $bot->onText('.*', function ($bot) {
        throw new Exception();
    });

    $bot->onMessageType(MessageTypes::PHOTO, function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('photo');

test('commands can have descriptions', function ($update) {
    $bot = getInstance($update);

    $cmd1 = $bot->onCommand('hELp', static function ($bot) {
    })->description('test');

    $cmd2 = $bot->onCommand('start {param}', static function ($bot) {
    })->description('test2');

    $cmd3 = $bot->onCommand('end', static function ($bot) {
    });

    expect($cmd1->getName())->toBe('help');
    expect($cmd1->getDescription())->toBe('test');
    expect($cmd1->isHidden())->toBeFalse();

    expect($cmd2->getName())->toBe('start');
    expect($cmd2->getDescription())->toBe('test2');
    expect($cmd2->isHidden())->toBeFalse();

    expect($cmd3->getName())->toBe('end');
    expect($cmd3->getDescription())->toBeNull();
    expect($cmd3->isHidden())->toBeTrue();
})->with('command_message');
