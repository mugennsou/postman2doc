<?php

namespace App\Writer;

class Markdown
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function word(string $content): void
    {
        $this->content .= $content;
    }

    /**
     * @param string $content
     */
    public function line(string $content): void
    {
        $this->word($content);
        $this->enter();
    }

    /**
     * @param int $lines
     */
    public function enter(int $lines = 1): void
    {
        $this->word(str_repeat("\n", $lines));
    }

    /**
     * @param string $content
     * @param int $h
     */
    public function h(string $content, int $h = 1): void
    {
        $this->word(str_repeat('#', $h) . " {$content}");
        $this->enter();
    }

    /**
     * @param string $content
     * @param string $url
     * @param int|null $h
     */
    public function link(string $content, string $url, int $h = null): void
    {
        $link = "[{$content}]({$url})";

        $this->isH($h) ? $this->h($link, $h) : $this->word($link);
    }

    /**
     * @param string $content
     * @param string|null $index
     * @param int|null $h
     */
    public function anchor(string $content, string $index = null, int $h = null): void
    {
        $index = $index ?? app('pinyin')->permalink($content);

        $anchor = "<%s id=\"{$index}\">{$content}</%s>";

        $isH = $this->isH($h);

        $label = $isH ? "h{$h}" : 'span';

        $anchor = str_replace('%s', $label, $anchor);

        $isH ? $this->line($anchor) : $this->word($anchor);
    }

    /**
     * @param string $content
     * @param string $index
     * @param int|null $h
     */
    public function anchorLink(string $content, string $index = null, int $h = null): void
    {
        $index = $index ?? app('pinyin')->permalink($content);

        $url = "#{$index}";

        $this->link($content, $url, $h);
    }

    /**
     * @param string $content
     * @param bool $multi
     */
    public function code(string $content, bool $multi = false): void
    {
        $codeSymbol = $multi ? '```' : '`';

        if ($multi) {
            $this->enter();
            $this->line($codeSymbol);
            $this->line($content);
            $this->line($codeSymbol);
        } else
            $this->word("{$codeSymbol}{$content}{$codeSymbol} ");
    }

    /**
     * Dividing line.
     */
    public function dividingLine(): void
    {
        $this->enter();
        $this->line('---');
        $this->enter();
    }

    /**
     * @param array $headers
     * @param array $rows
     * @param string $align
     */
    public function table(array $headers, array $rows, string $align = 'left'): void
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

        $this->line($headerLine);
        $this->line($dividingLine);

        foreach ($rows as $row) {
            $rowLine = '|';

            foreach ($headers as $header)
                $rowLine .= ' ' . ($row[$header] ?? '-') . ' |';

            $this->line($rowLine);
        }
    }

    /**
     * @param int|null $h
     * @return bool
     */
    protected function isH(int $h = null): bool
    {
        return is_int($h) && $h > 0 && $h < 7;
    }
}
