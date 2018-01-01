<?php

namespace App\Writer;

class Html
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var boolean
     */
    protected $converted = false;

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
        $this->converted = true;

        return $this->content;
    }

    /**
     * @return bool
     */
    public function converted()
    {
        return $this->converted;
    }

    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        file_put_contents("{$path}.html", $this->toString());
    }
}