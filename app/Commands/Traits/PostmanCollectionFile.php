<?php

namespace App\Commands\Traits;

trait PostmanCollectionFile
{
    /**
     * Collections.
     * @var array
     */
    protected $collections = [];

    /**
     * Get file real path.
     * @param string $filePath
     * @param string|null $workDir
     * @return string
     */
    public function getFileRealPath(string $filePath, string $workDir = null): string
    {
        $workDir = $workDir ?? getcwd();

        $realPath = starts_with($filePath, '/') || preg_match('/^\w\:[\/\\\]/', $filePath)
            ? $filePath
            : "$workDir/$filePath";

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
        if (!is_file($filePath))
            $this->abort('File not exists.');

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
}