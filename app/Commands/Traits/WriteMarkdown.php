<?php

namespace App\Commands\Traits;

use Illuminate\Support\Facades\Storage;

trait WriteMarkdown
{
    protected $outputFile = 'postman.markdown';

    protected $content = '';

    protected function setOutputFile(string $outputFile): void
    {
        $this->outputFile = $outputFile;

        if (is_file($this->outputFile)) {
            $force = $this->confirm("$outputFile is already exists, overwrite it?");
            $force || $this->error('Output file is already exists.');
        }

        $this->createFile();
    }

    protected function createFile(): void
    {
        Storage::put($this->outputFile, '');
    }

    /**
     * write h1, h2 etc.
     * @param string $content
     * @param int $h
     */
    protected function writeH(string $content, int $h = 1): void
    {
        if ($h < 0 || $h > 6)
            $h = 1;

        $this->writeLine(str_repeat('#', $h) . "{$content}");
    }

    /**
     * Write anchor.
     * @param string $content
     * @param string|null $index
     * @param int|null $h
     */
    protected function writeAnchor(string $content, string $index = null, int $h = null): void
    {
        $index = $index ?? $content;

        $anchor = "<%s id=\"{$index}\">{$content}</%s>";

        $label = (is_int($h) && $h > 0 && $h < 7) ? "h{$h}" : 'span';

        $anchor = str_replace('%s', $label, $anchor);

        $this->writeLine($anchor);
    }

    protected function writeAnchorLink(string $content, string $index, int $h = null): void
    {
        $url = "#{$index}";

        $this->writeLink($content, $url, $h);
    }

    protected function writeLink(string $content, string $url, int $h = null): void
    {
        $link = "[{$content}]({$url})";

        (is_int($h) && $h > 0 && $h < 7)
            ? $this->writeH($link, $h)
            : $this->writeLine($link, false);
    }

    /**
     * @param array $headers
     * @param array $rows
     * @param string $align left,right,center
     */
    protected function writeTable(array $headers, array $rows, string $align = 'left'): void
    {
        $headerLine   = '|';
        $dividingLine = '|';

        foreach ($headers as $header) {
            $headerLine .= " {$header} |";

            if ($align === 'left' || $align === 'center')
                $dividingLine .= ':';

            $dividingLine .= "---";

            if ($align === 'right' || $align === 'center')
                $dividingLine .= ':';

            $dividingLine .= '|';
        }

        unset($header);

        $this->writeLine($headerLine);
        $this->writeLine($dividingLine);

        foreach ($rows as $row) {
            $rowLine = '|';

            foreach ($headers as $header)
                $rowLine .= ' ' . ($row[$header] ?? '-') . ' |';

            $this->writeLine($rowLine);
        }
    }

    protected function writeCode(string $content, bool $multi = false): void
    {
        $codeSymbol = $multi ? '```' : '`';

        $this->writeLine($codeSymbol, $multi);
        $this->writeLine($content, $multi);
        $this->writeLine("{$codeSymbol} ", $multi);
    }

    /**
     * Write a line.
     * @param string $content
     * @param bool $enter
     */
    protected function writeLine(string $content = '', bool $enter = true): void
    {
        $this->write("{$content}");

        $enter && $this->writeEnter();
    }

    /**
     * Write a enter.
     * @param int $lines
     */
    protected function writeEnter(int $lines = 1): void
    {
        $lines > 0 && $this->write(str_repeat("\n", $lines));
    }

    /**
     * Write to file
     * @param string $content
     */
    protected function write(string $content): void
    {
        $this->content .= $content;
    }

    protected function openFile(): void
    {
        $this->createFile();
    }

    protected function closeFile(): void
    {
        Storage::append($this->outputFile, $this->content, '');
    }
}
