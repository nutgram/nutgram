<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class IdeGenerateCommand extends Command
{
    protected $signature = 'nutgram:ide:generate';

    protected $description = 'Generate IDE helper for Nutgram';

    public function handle(): int
    {
        $this->info('Generating IDE helper...');

        $helper = file_get_contents(__DIR__.'/../Stubs/Ide.stub');

        File::put(base_path('_ide_helper_nutgram.php'), $helper);

        $this->info('Done!');

        return 0;
    }
}
