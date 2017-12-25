<?php

namespace App\Commands;

trait PostmanCollectionFile
{
    protected function getFileVersion(string $filePath): string
    {
        return $this->getCollectionVersion($this->getFileContent($filePath));
    }

    protected function getFileContent(string $filePath): array
    {
        if (!is_file($filePath))
            $this->error('File not exists.');

        $content = json_decode(file_get_contents($filePath), true);

        return json_last_error() !== 0 ? [] : $content;
    }

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