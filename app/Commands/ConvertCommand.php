<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertCommand extends Command
{
    use FilePath,
        PostmanCollectionFile;

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

        $postmanFilePath = $this->realPath($postmanFile, $workDir);

        switch ($this->getFileVersion($postmanFilePath)) {
            case 'v1.0.0':
                $isVersion1 = $this->confirm('Is this postman collection version 1.0.0 ?');

                $isVersion1
                    ? $this->call('convert10', [
                    'file' => $postmanFilePath
                ])
                    : $this->warn('User aborted.');

                break;
            case 'v2.0.0':

                $this->call('convert20', [
                    'file' => $postmanFilePath
                ]);

                break;
            case 'v2.1.0':

                $this->call('convert21', [
                    'file' => $postmanFilePath
                ]);

                break;
            default:

                $this->error('Unknown version postman collection.');

                break;
        }
    }
}
