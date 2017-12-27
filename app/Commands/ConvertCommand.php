<?php

namespace App\Commands;

use App\Commands\Traits\PostmanCollectionFile;

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
            $filePath = $this->getFileRealPath($file);

            return is_file($filePath) && ends_with($filePath, '.json');
        });

        $postmanFile = $maybePostmanFiles->count()
            ? $this->choice('Which postman collection file do you want to convert ?', $maybePostmanFiles->toArray())
            : $this->ask('Please type the postman collection file path.');

        $postmanFilePath = $this->getFileRealPath($postmanFile, $workDir);

        switch ($this->getFileVersion($postmanFilePath)) {
            case 'v1.0.0':
                $command  = 'convert10';
                $version1 = $this->confirm('Is this postman collection version 1.0.0 ?');
                $version1 || $this->abort('User abort.');
                break;
            case 'v2.0.0':
                $command = 'convert20';
                break;
            case 'v2.1.0':
                $command = 'convert21';
                break;
            default:
                $this->abort('Unknown version postman collection.');
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
