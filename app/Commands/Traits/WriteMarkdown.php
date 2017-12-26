<?php

namespace App\Commands\Traits;

use Illuminate\Support\Facades\Storage;

trait WriteMarkdown
{
    protected $outputFile = 'postman.markdown';

    protected function setOutputFile(string $outputFile)
    {
        $this->outputFile = $outputFile;

        if (is_file($this->outputFile)) {
            $force = $this->confirm("$outputFile is already exists, overwrite it?");
            $force || $this->error('Output file is already exists.');
        }

        $this->createFile();
    }

    protected function append(string $content): void
    {
        Storage::append($this->outputFile, $content);
    }

    protected function prepend(string $content): void
    {
        Storage::prepend($this->outputFile, $content);
    }

    protected function createFile(): void
    {
        Storage::put($this->outputFile, '');
    }
}
