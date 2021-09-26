<?php


namespace SergiX44\Nutgram;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use SergiX44\Nutgram\Laravel\Commands\HookInfoCommand;
use SergiX44\Nutgram\Laravel\Commands\HookRemoveCommand;
use SergiX44\Nutgram\Laravel\Commands\HookSetCommand;
use SergiX44\Nutgram\Laravel\Commands\RegisterCommandsCommand;
use SergiX44\Nutgram\Laravel\Commands\RunCommand;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;

/**
 * The Nutgram Service Provider for Laravel.
 */
class NutgramServiceProvider extends ServiceProvider
{
    /** @var string */
    public static string $ROUTES = 'routes/telegram.php';

    /**
     * Register the bot instance
     */
    public function register()
    {
        $this->app->singleton(Nutgram::class, function (Application $app) {
            $config = array_merge([
                'cache' => $app->make(Cache::class),
            ], config('nutgram.config'));

            $bot = new Nutgram(config('nutgram.token'), $config);

            if ($app->runningInConsole()) {
                $bot->setRunningMode(Polling::class);
            } else {
                $bot->setRunningMode(Webhook::class);
            }

            return $bot;
        });

        $this->app->alias(Nutgram::class, 'nutgram');

        $this->mergeConfigFrom(__DIR__.'/../laravel/config.php', 'nutgram');
    }

    /**
     * Load bot commands and callbacks
     */
    public function boot()
    {
        $this->commands([
            RunCommand::class,
            RegisterCommandsCommand::class,
            HookInfoCommand::class,
            HookRemoveCommand::class,
            HookSetCommand::class,
        ]);

        $this->publishes([
            __DIR__ . '/../laravel/config.php' => config_path('nutgram.php'),
            __DIR__ . '/../laravel/routes.php' => base_path(self::$ROUTES),
        ], 'nutgram');

        if (config('nutgram.routes', false) && file_exists(self::$ROUTES)) {
            $bot = $this->app['nutgram'];
            require base_path(self::$ROUTES);
        }
    }
}
