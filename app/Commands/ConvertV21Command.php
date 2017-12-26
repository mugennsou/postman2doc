<?php

namespace App\Commands;

use App\Commands\Traits\PostmanCollectionFile;
use App\Commands\Traits\WriteMarkdown;
use LaravelZero\Framework\Commands\Command;

class ConvertV21Command extends Command
{
    use PostmanCollectionFile,
        WriteMarkdown;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert21
                                    {file : The postman collection version 2.1.0 filename}
                                    {output : Output file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection to markdown.';

    /**
     * @var string
     */
    protected $version = 'v2.1.0';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $file = $this->argument('file');

        if ($this->getFileVersion($file) !== $this->version)
            $this->error('This postman collection is not version 2.1.0');

        $info  = $this->getFileContent($file)['info'];
        $items = collect($this->getFileContent($file)['item']);

        $content = $this->parseInfo($info);

        $items->each(function ($item) use ($content) {
            $this->line($item['name']);
        });

        $this->setOutputFile($this->argument('output'));

        $this->append($content);
    }

    protected function parseInfo(array $info): string
    {
        $title       = $info['name'];
        $description = $info['description'];

        return "#{$title}\n$description\n\n\n";
    }

    protected function parseFolderItem(array $item): string
    {

    }

    protected function parseRequestItem(array $item): string
    {

    }
}
