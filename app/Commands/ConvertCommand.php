<?php

namespace App\Commands;

use App\Postman\Collection;
use LaravelZero\Framework\Commands\Command;

class ConvertCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert
                                    {file? : The postman collection filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection file to markdown.';

    /**
     * Collections.
     * @var array
     */
    protected $collections = [];

    /**
     * @var array
     */
    protected $supportVersions = [
        'v2.0.0',
        'v2.1.0',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $file = $this->argument('file');

        if ($file)
            $postmanFilePath = $this->getFileRealPath($file);
        else {
            $maybePostmanFiles = $this->getMaybePostmanFiles();
            $postmanFilePath   = $this->getUserChoiceCollectionFile($maybePostmanFiles->toArray());
        }

        in_array($version = $this->getFileVersion($postmanFilePath), $this->supportVersions)
        || $this->abort("Do not support version [{$version}] postman collection.");

        $collection = new Collection($this->getFileContent($postmanFilePath));

        $defaultOutputFilePath = $postmanFilePath . '.markdown';

        $this->outputFile($defaultOutputFilePath, $collection->toMarkdown());

        $this->notify('Convert success.', "see it {$defaultOutputFilePath}");
    }

    protected function outputFile(string $outputFilePath, string $content)
    {
        return file_put_contents($outputFilePath, $content);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getMaybePostmanFiles(): \Illuminate\Support\Collection
    {
        return collect(scandir(getcwd()))->filter(function ($file) {
            $filePath = $this->getFileRealPath($file);

            return ends_with($filePath, '.json') && is_file($filePath);
        })->values();
    }

    /**
     * @param array $files
     * @return string
     */
    protected function getUserChoiceCollectionFile(array $files = []): string
    {
        $file = count($files)
            ? $this->choice('Please type [index] which file you want to convert', $files)
            : $this->ask('Please type the postman collection file path');

        return $this->getFileRealPath($file);
    }

    /**
     * Get file real path.
     * @param string $fileName
     * @param string|null $workDir
     * @return string
     */
    protected function getFileRealPath(string $fileName, string $workDir = null): string
    {
        $workDir = $workDir ?? getcwd();

        $realPath = starts_with($fileName, '/') || preg_match('/^\w\:[\/\\\]/', $fileName)
            ? $fileName
            : "$workDir/$fileName";

        return $realPath;
    }

    /**
     * Get collection file version.
     * @param string $filePath
     * @return string
     */
    protected function getFileVersion(string $filePath): string
    {
        return strtolower($this->getCollectionVersion($this->getFileContent($filePath)));
    }

    /**
     * Get file content.
     * @param string $filePath
     * @return array
     */
    protected function getFileContent(string $filePath): array
    {
        is_file($filePath) || $this->abort('File not exists.');

        if (isset($this->collections[$filePath]))
            return $this->collections[$filePath];

        $content = json_decode(file_get_contents($filePath), true);

        return $this->collections[$filePath] = json_last_error() !== 0 ? [] : $content;
    }

    /**
     * Get collection version.
     * @param array $collection
     * @return string
     */
    protected function getCollectionVersion(array $collection): string
    {
        $versionUrl = array_get($collection, 'info.schema');

        if (is_null($versionUrl)) {
            if (array_key_exists('id', $collection) || array_key_exists('requests', $collection))
                return 'v1.0.0';
        } else {
            if (str_contains($versionUrl, 'v2.0.0'))
                return 'v2.0.0';

            if (str_contains($versionUrl, 'v2.1.0'))
                return 'v2.1.0';
        }

        return 'unknown';
    }

    /**
     * @param string $error
     */
    protected function abort(string $error)
    {
        $this->error($error);
        exit();
    }
}
