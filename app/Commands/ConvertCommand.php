<?php

namespace App\Commands;

use App\Commands\Traits\PostmanCollectionFile;
use LaravelZero\Framework\Commands\Command;

class ConvertCommand extends Command
{
    use PostmanCollectionFile;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection to markdown.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $workDir = getcwd();

        $maybePostmanFiles = collect(scandir($workDir))->filter(function ($file) {
            return is_file($file) && ends_with($file, '.json');
        });

        $postmanFile = $this->anticipate(
            'Which postman collection file do you want to convert ?',
            $maybePostmanFiles->toArray()
        );

        $postmanFilePath = $this->getFileRealPath($postmanFile, $workDir);

        switch ($this->getFileVersion($postmanFilePath)) {
            case 'v1.0.0':
                $command  = 'convert10';
                $version1 = $this->confirm('Is this postman collection version 1.0.0 ?');
                $version1 || $this->error('User abort.');
                break;
            case 'v2.0.0':
                $command = 'convert20';
                break;
            case 'v2.1.0':
                $command = 'convert21';
                break;
            default:
                $this->error('Unknown version postman collection.');
                break;
        }

        $defaultOutputFile = pathinfo($postmanFilePath)['filename'];

        $outputFile = $this->getFileRealPath(
            $this->ask('Pleas type output filename:', $defaultOutputFile) . '.markdown'
        );

        $this->call($command, [
            'file'   => $postmanFilePath,
            'output' => $outputFile,
        ]);
    }
}
