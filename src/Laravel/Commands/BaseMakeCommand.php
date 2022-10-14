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
    abstract protected function getSubDirName(): string;

    /**
     * Return the stub file path
     * @return string
     */
    abstract protected function getStubPath(): string;

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    protected function getStubVariables(): array
    {
        /** @var string $name */
        $name = $this->argument('name');

        return [
            'namespace' => $this->getSubDirName().$this->getNamespace($name),
            'name' => class_basename($name),
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

    /**
     * Get the full namespace for a given class, without the class name.
     *
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace(string $name): string
    {
        $namespace = $this->removeClassName($this->slashesTrim($name));

        if (empty($namespace)) {
            return '';
        }

        return '\\'.$namespace;
    }


    /**
     * remove duplicated slashes
     *
     * @param  string  $name
     * @param  string  $replacement
     * @return string
     */
    protected function slashesTrim(string $name, string $replacement = '\\'): string
    {
        return preg_replace('#[\\\/]+#', $replacement, $name);
    }

    /**
     * returns namespace from full class name
     *
     * @param  string  $name
     * @return string
     */
    protected function removeClassName(string $name): string
    {
        return trim(dirname($name), '\\/.');
    }
}
