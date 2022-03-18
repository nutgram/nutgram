<?php


namespace SergiX44\Nutgram;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use SergiX44\Nutgram\Laravel\Commands\HookInfoCommand;
use SergiX44\Nutgram\Laravel\Commands\HookRemoveCommand;
use SergiX44\Nutgram\Laravel\Commands\HookSetCommand;
use SergiX44\Nutgram\Laravel\Commands\ListCommand;
use SergiX44\Nutgram\Laravel\Commands\RegisterCommandsCommand;
use SergiX44\Nutgram\Laravel\Commands\RunCommand;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Testing\FakeNutgram;

/**
 * The Nutgram Service Provider for Laravel.
 */
class NutgramServiceProvider extends ServiceProvider
{
    /** @var string */
    public string $telegramRoutes;

    /**
     * Register the bot instance
     */
    public function register()
    {
        $this->telegramRoutes = $this->app->basePath('routes/telegram.php');

        $this->mergeConfigFrom(__DIR__.'/../laravel/config.php', 'nutgram');

        $this->app->singleton(Nutgram::class, function (Application $app) {
            if ($app->runningUnitTests()) {
                return Nutgram::fake();
            }

            $config = array_merge([
                'cache' => $app->make(Cache::class),
            ], config('nutgram.config'));

            $bot = new Nutgram(config('nutgram.token') ?? '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', $config);

            if ($app->runningInConsole()) {
                $bot->setRunningMode(Polling::class);
            } else {
                $safeMode = config('nutgram.safe_mode', false);
                $webhook = (new Webhook())->setSafeMode($safeMode);

                if ($safeMode) {
                    // take into account the trust proxy Laravel configuration
                    $webhook->requestIpFrom(fn () => request()?->ip());
                }

                $bot->setRunningMode($webhook);
            }

            return $bot;
        });

        $this->app->alias(Nutgram::class, 'nutgram');
        $this->app->alias(Nutgram::class, FakeNutgram::class);
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
            ]);

            $this->publishes([
                __DIR__.'/../laravel/config.php' => config_path('nutgram.php'),
                __DIR__.'/../laravel/routes.php' => $this->telegramRoutes,
            ], 'nutgram');
        }

        if (config('nutgram.routes', false)) {
            $bot = $this->app->make(Nutgram::class);
            require file_exists($this->telegramRoutes) ? $this->telegramRoutes : __DIR__.'/../laravel/routes.php';
        }

        $this->registerMacros();
    }

    /**
     * Register the bot macros
     * @return void
     */
    public function registerMacros(): void
    {
        Nutgram::macro(
            'downloadFileToDisk',
            function (File $file, string $path, string $disk = null, array $clientOpt = []): string {
                /** @var Nutgram $this */
                if (is_dir($path)) {
                    $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
                    $path .= basename($file->file_path);
                }

                $savedPath = Storage::disk($disk)->path($path);

                Http::withOptions(array_merge(['sink' => $savedPath, $clientOpt]))
                    ->get($this->downloadUrl($file))
                    ->throw();

                return $savedPath;
            }
        );

        File::macro('saveToDisk', function (string $path, string $disk = null, array $clientOpt = []): string {
            /** @var File $this */
            if (is_dir($path)) {
                $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
                $path .= basename($this->file_path);
            }

            $savedPath = Storage::disk($disk)->path($path);

            Http::withOptions(array_merge(['sink' => $savedPath, $clientOpt]))
                ->get($this->downloadUrl($this))
                ->throw();

            return $savedPath;
        });
    }
}
