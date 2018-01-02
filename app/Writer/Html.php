<?php

namespace App\Writer;
/**
 * Class Html
 * @package App\Writer
 * @method word(string $content): void
 * @method line(string $content): void
 * @method enter(int $lines = 1): void
 * @method h(string $content, int $h = 1): void
 * @method link(string $content, string $url, int $h = null): void
 * @method anchor(string $content, string $index = null, int $h = null): void
 * @method anchorLink(string $content, string $index = null, int $h = null): void
 * @method code(string $content, bool $multi = false): void
 * @method dividingLine(): void
 * @method table(array $headers, array $rows, string $align = 'left'): void
 */
class Html
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $methods = [
        'word',
        'line',
        'enter',
        'h',
        'link',
        'anchor',
        'anchorLink',
        'code',
        'dividingLine',
        'table',
    ];

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->content ?? $this->content = app('parsedown')->text(app('markdown')->toString());
    }

    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        file_put_contents("{$path}.html", $this->toString());
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments): void
    {
        /**
         * @var \App\Writer\Markdown|\App\Writer\Html|\App\Writer\Docx $writer
         */
        $writer = app('markdown');

        if (in_array($name, $this->methods)) {
            /**
             * @var Markdown $markdown
             */

            $writer->converted() || $writer->{$name}(...$arguments);
        }
    }
}