<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Feature\Commands\DumbCommand;

// NESTING

it('groups middleware with nesting level 1', function ($update) {
    $bot = Nutgram::fake($update);
    $test = '';

    $middleware0 = function ($bot, $next) use (&$test) {
        $test .= '-[MW0]';
        $next($bot);
    };

    $middleware1 = function ($bot, $next) use (&$test) {
        $test .= '[MW1]';
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group($middleware1, function (Nutgram $bot) use (&$test) {
        $bot->onMessage(function (Nutgram $bot) use (&$test) {
            $test .= 'H1';
        })->middleware(function (Nutgram $bot, $next) use (&$test) {
            $test .= 'LM1';
            $next($bot);
        });
    });

    $bot->onMessage(function (Nutgram $bot) use (&$test) {
        $test .= 'H2';
    })->middleware(function (Nutgram $bot, $next) use (&$test) {
        $test .= 'LM2';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('-[MW0][MW1]LM1H1-[MW0]LM2H2');
})->with('message');

it('groups middleware with 2 nesting levels 1', function ($update) {
    $bot = Nutgram::fake($update);
    $test = '';

    $middleware0 = function ($bot, $next) use (&$test) {
        $test .= '-[MW0]';
        $next($bot);
    };

    $middleware1 = function ($bot, $next) use (&$test) {
        $test .= '[MW1]';
        $next($bot);
    };

    $middleware2 = function ($bot, $next) use (&$test) {
        $test .= '[MW2]';
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group($middleware1, function (Nutgram $bot) use (&$test) {
        $bot->onMessage(function (Nutgram $bot) use (&$test) {
            $test .= 'H1';
        })->middleware(function (Nutgram $bot, $next) use (&$test) {
            $test .= 'LM1';
            $next($bot);
        });
    });

    $bot->group([$middleware1, $middleware2], function (Nutgram $bot) use (&$test) {
        $bot->onMessage(function (Nutgram $bot) use (&$test) {
            $test .= 'H2';
        })->middleware(function (Nutgram $bot, $next) use (&$test) {
            $test .= 'LM2';
            $next($bot);
        });
    });

    $bot->onMessage(function (Nutgram $bot) use (&$test) {
        $test .= 'H3';
    })->middleware(function (Nutgram $bot, $next) use (&$test) {
        $test .= 'LM3';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('-[MW0][MW1]LM1H1-[MW0][MW1][MW2]LM2H2-[MW0]LM3H3');
})->with('message');

it('groups middleware with nesting level 2', function ($update) {
    $bot = Nutgram::fake($update);
    $test = '';

    $middleware0 = function ($bot, $next) use (&$test) {
        $test .= '-[MW0]';
        $next($bot);
    };

    $middleware1 = function ($bot, $next) use (&$test) {
        $test .= '[MW1]';
        $next($bot);
    };

    $middleware2 = function ($bot, $next) use (&$test) {
        $test .= '[MW2]';
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group($middleware1, function (Nutgram $bot) use ($middleware2, &$test) {
        $bot->group($middleware2, function (Nutgram $bot) use (&$test) {
            $bot->onMessage(function (Nutgram $bot) use (&$test) {
                $test .= 'H1';
            })->middleware(function (Nutgram $bot, $next) use (&$test) {
                $test .= 'LM1';
                $next($bot);
            });
        });

        $bot->onMessage(function (Nutgram $bot) use (&$test) {
            $test .= 'H2';
        })->middleware(function (Nutgram $bot, $next) use (&$test) {
            $test .= 'LM2';
            $next($bot);
        });
    });

    $bot->onMessage(function (Nutgram $bot) use (&$test) {
        $test .= 'H3';
    })->middleware(function (Nutgram $bot, $next) use (&$test) {
        $test .= 'LM3';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('-[MW0][MW1][MW2]LM1H1-[MW0][MW1]LM2H2-[MW0]LM3H3');
})->with('message');

it('groups middleware with complex nesting levels', function ($update) {
    $bot = Nutgram::fake($update);
    $test = '';

    $middleware0 = function ($bot, $next) use (&$test) {
        $test .= '-[MW0]';
        $next($bot);
    };

    $middleware1 = function ($bot, $next) use (&$test) {
        $test .= '[MW1]';
        $next($bot);
    };

    $middleware2 = function ($bot, $next) use (&$test) {
        $test .= '[MW2]';
        $next($bot);
    };

    $middleware3 = function ($bot, $next) use (&$test) {
        $test .= '[MW3]';
        $next($bot);
    };

    $middleware4 = function ($bot, $next) use (&$test) {
        $test .= '[MW4]';
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group(
        $middleware1,
        function (Nutgram $bot) use ($middleware4, $middleware3, $middleware2, $middleware1, &$test) {
            $bot->group(
                [$middleware1, $middleware2],
                function (Nutgram $bot) use ($middleware1, $middleware4, $middleware3, &$test) {
                    $bot->group(
                        $middleware3,
                        function (Nutgram $bot) use ($middleware1, $middleware4, &$test) {
                            $bot->group([$middleware1, $middleware4], function (Nutgram $bot) use (&$test) {
                                $bot->onMessage(function (Nutgram $bot) use (&$test) {
                                    $test .= 'HX';
                                })->middleware(function (Nutgram $bot, $next) use (&$test) {
                                    $test .= 'LMX';
                                    $next($bot);
                                });
                            });

                            $bot->onMessage(function (Nutgram $bot) use (&$test) {
                                $test .= 'H0';
                            })->middleware(function (Nutgram $bot, $next) use (&$test) {
                                $test .= 'LM0';
                                $next($bot);
                            });
                        }
                    );

                    $bot->onMessage(function (Nutgram $bot) use (&$test) {
                        $test .= 'H1';
                    })->middleware(function (Nutgram $bot, $next) use (&$test) {
                        $test .= 'LM1';
                        $next($bot);
                    });
                }
            );

            $bot->onMessage(function (Nutgram $bot) use (&$test) {
                $test .= 'H2';
            })->middleware(function (Nutgram $bot, $next) use (&$test) {
                $test .= 'LM2';
                $next($bot);
            });
        }
    );

    $bot->onMessage(function (Nutgram $bot) use (&$test) {
        $test .= 'H3';
    })->middleware(function (Nutgram $bot, $next) use (&$test) {
        $test .= 'LM3';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('-[MW0][MW1][MW1][MW2][MW3][MW1][MW4]LMXHX-[MW0][MW1][MW1][MW2][MW3]LM0H0-[MW0][MW1][MW1][MW2]LM1H1-[MW0][MW1]LM2H2-[MW0]LM3H3');
})->with('message');

// COMMAND HANDLERS

it('groups middleware with onCommand', function ($update) {
    $bot = Nutgram::fake($update);
    $test = '';

    $middleware0 = function ($bot, $next) use (&$test) {
        $test .= '-[MW0]';
        $next($bot);
    };

    $middleware1 = function ($bot, $next) use (&$test) {
        $test .= '[MW1]';
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group($middleware1, function (Nutgram $bot) use (&$test) {
        $bot->onCommand('test', function (Nutgram $bot) use (&$test) {
            $test .= 'H1';
        })->middleware(function (Nutgram $bot, $next) use (&$test) {
            $test .= 'LM1';
            $next($bot);
        });
    });

    $bot->run();

    expect($test)->toBe('-[MW0][MW1]LM1H1');
})->with('command');

it('groups middleware with registerCommand', function ($update) {
    $bot = Nutgram::fake($update);

    $middleware0 = function (Nutgram $bot, $next) {
        $bot->setGlobalData('flow', $bot->getGlobalData('flow', '').'-[MW0]');
        $next($bot);
    };

    $middleware1 = function (Nutgram $bot, $next) {
        $bot->setGlobalData('flow', $bot->getGlobalData('flow', '').'[MW1]');
        $next($bot);
    };

    $bot->middleware($middleware0);

    $bot->group($middleware1, function (Nutgram $bot) {
        $bot->registerCommand(DumbCommand::class)->middleware(function (Nutgram $bot, $next) {
            $bot->setGlobalData('flow', $bot->getGlobalData('flow', '').'LM');
            $next($bot);
        });
    });

    $bot->run();

    expect($bot->getGlobalData('flow', ''))->toBe('-[MW0][MW1]LMH');
})->with('command');

// USE CASES

it('groups middleware with on*Data/Payload handlers', function ($update) {
    $bot = Nutgram::fake($update);

    $test = '';

    $middlewareA = function ($bot, $next) use (&$test) {
        $test .= '-[MA]';
        $next($bot);
    };

    $middlewareB = function ($bot, $next) use (&$test) {
        $test .= '[MB]';
        $next($bot);
    };

    $middlewareC = function ($bot, $next) use (&$test) {
        $test .= '[MC]';
        $next($bot);
    };

    $middlewareD = function ($bot, $next) use (&$test) {
        $test .= '[MD]';
        $next($bot);
    };

    $bot->middleware($middlewareA);

    $bot->group($middlewareB, function (Nutgram $bot) use (&$test, $middlewareC, $middlewareD) {
        $bot->onCallbackQuery(function (Nutgram $bot) use (&$test) {
            $test .= 'H1';
        });


        $bot->onCallbackQueryData('thedata', function (Nutgram $bot) use (&$test) {
            $test .= 'H2';
        });

        $bot->group([$middlewareC, $middlewareD], function (Nutgram $bot) use (&$test) {
            // TODO
        });
    });

    $bot->run();

    expect($test)->toBe('-[MA][MB]H2');
})->with('callback_query');
