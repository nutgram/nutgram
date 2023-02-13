<?php


namespace SergiX44\Nutgram;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Laravel\Commands\HookInfoCommand;
use SergiX44\Nutgram\Laravel\Commands\HookRemoveCommand;
use SergiX44\Nutgram\Laravel\Commands\HookSetCommand;
use SergiX44\Nutgram\Laravel\Commands\IdeGenerateCommand;
use SergiX44\Nutgram\Laravel\Commands\ListCommand;
use SergiX44\Nutgram\Laravel\Commands\LogoutCommand;
use SergiX44\Nutgram\Laravel\Commands\MakeCommandCommand;
use SergiX44\Nutgram\Laravel\Commands\MakeConversationCommand;
use SergiX44\Nutgram\Laravel\Commands\MakeHandlerCommand;
use SergiX44\Nutgram\Laravel\Commands\MakeMiddlewareCommand;
use SergiX44\Nutgram\Laravel\Commands\RegisterCommandsCommand;
use SergiX44\Nutgram\Laravel\Commands\RunCommand;
use SergiX44\Nutgram\Laravel\Mixins\FileMixin;
use SergiX44\Nutgram\Laravel\Mixins\NutgramMixin;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Testing\FakeNutgram;

/**
 * The Nutgram Service Provider for Laravel.
 */
class NutgramServiceProvider extends ServiceProvider
{
    protected const CONFIG_PATH = __DIR__.'/Laravel/Config/config.php';
    protected const ROUTES_PATH = __DIR__.'/Laravel/Routes/routes.php';

    /** @var string */
    public string $telegramRoutes;

    /**
     * Register the bot instance
     */
    public function register()
    {
        $this->telegramRoutes = $this->app->basePath('routes/telegram.php');

        $this->mergeConfigFrom(self::CONFIG_PATH, 'nutgram');

        $this->app->singleton(Nutgram::class, function (Application $app) {
            if ($app->runningUnitTests()) {
                return Nutgram::fake();
            }

            $bot = new Nutgram(config('nutgram.token') ?? FakeNutgram::TOKEN, array_merge([
                'container' => $app,
                'cache' => $app->get(Cache::class),
                'logger' => $app->get(LoggerInterface::class)->channel(config('nutgram.log_channel', 'null')),
            ], config('nutgram.config', [])));

            if ($app->runningInConsole()) {
                $bot->setRunningMode(Polling::class);
            } else {
                $webhook = Webhook::class;
                if (config('nutgram.safe_mode', false)) {
                    // take into account the trust proxy Laravel configuration
                    $webhook = new Webhook(fn () => $app->make('request')?->ip());
                }

                $bot->setRunningMode($webhook);
            }

            return $bot;
        });

        $this->app->alias(Nutgram::class, 'nutgram');
        $this->app->alias(Nutgram::class, FakeNutgram::class);

        if (config('nutgram.mixins', false)) {
            Nutgram::mixin(new NutgramMixin());
            File::mixin(new FileMixin());
        }
    }

    /**
     *  Load bot commands and callbacks
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RunCommand::class,
                RegisterCommandsCommand::class,
                HookInfoCommand::class,
                HookRemoveCommand::class,
                HookSetCommand::class,
                ListCommand::class,
                MakeCommandCommand::class,
                MakeConversationCommand::class,
                MakeHandlerCommand::class,
                MakeMiddlewareCommand::class,
                IdeGenerateCommand::class,
                LogoutCommand::class,
            ]);

            $this->publishes([
                self::CONFIG_PATH => config_path('nutgram.php'),
                self::ROUTES_PATH => $this->telegramRoutes,
            ], 'nutgram');
        }

        if (config('nutgram.routes', false)) {
            $bot = $this->app->get(Nutgram::class);
            require file_exists($this->telegramRoutes) ? $this->telegramRoutes : self::ROUTES_PATH;
        }
    }
}
