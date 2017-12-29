<?php

namespace App\Writer;

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
}