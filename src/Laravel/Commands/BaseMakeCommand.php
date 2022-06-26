<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

abstract class BaseMakeCommand extends Command
{
    protected $signature = 'nutgram:make:? {name : ? name}';

    protected $description = 'Create a new Nutgram ?';

    public function handle(): int
    {
        //get the file name
        $name = $this->argument('name');

        //get stub content
        $stub = $this->getStubContent($this->getStubPath(), $this->getStubVariables());

        //get destination path
        $path = config('nutgram.namespace').'/'.$this->getSubDirName().'/'.$name.'.php';

        //create directory if it doesn't exist
        $this->makeDirectory($path);

        //write stub to file
        File::put($path, $stub);

        $this->info('Nutgram '.Str::singular($this->getSubDirName()).' created successfully.');
        return 0;
    }

    /**
     * Return the sub directory name
     * @return string
     */
    protected function getSubDirName(): string
    {
        return '?';
    }

    /**
     * Return the stub file path
     * @return string
     */
    protected function getStubPath(): string
    {
        return __DIR__.'/../Stubs/?.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     * @return array
     */
    protected function getStubVariables(): array
    {
        return [
            'namespace' => $this->getSubDirName(),
            'name' => $this->argument('name'),
        ];
    }

    /**
     * Replace the stub variables with the desire value
     * @param  string  $path
     * @param  array  $variables
     * @return string
     */
    protected function getStubContent(string $path, array $variables = []): string
    {
        $content = File::get($path);
        foreach ($variables as $key => $value) {
            $content = str_replace("{{ $key }}", $value, $content);
        }
        return $content;
    }

    /**
     * Build the directory for the class if necessary.
     * @param  string  $path
     * @return void
     */
    protected function makeDirectory(string $path): void
    {
        $path = dirname($path);

        if (File::isDirectory($path)) {
            return;
        }

        if (!File::makeDirectory($path, 0755, true)) {
            throw new RuntimeException('Unable to create directory: '.$path);
        }
    }
}
