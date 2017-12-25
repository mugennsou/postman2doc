<?php

namespace App\Commands;

trait FilePath
{
    public function realPath(string $filePath, string $workDir = null): string
    {
        $workDir = $workDir ?? getcwd();

        $realPath = starts_with($filePath, '/') ? $filePath : $workDir . '/' . $filePath;

        return $realPath;
    }
}