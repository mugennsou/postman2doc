<?php

namespace App\Writer;

use App\Postman\Collection;

class Html
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param string $markdown
     */
    public function markdown(string $markdown): void
    {
        $this->content .= app('parsedown')->text($markdown);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->content;
    }

    /**
     * @param Collection $collection
     * @param string $path
     */
    public function save(Collection $collection, string $path): void
    {
        file_put_contents("{$path}.html", $collection->toHtml());
    }
}