<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Url implements Markdownable
{
    /**
     * @var string
     */
    protected $url;

    /**
     * Url constructor.
     * @param $url
     */
    public function __construct($url)
    {
        is_array($url) ? $this->parseUrl($url) : $this->setUrl($url);
    }

    /**
     * @param array $url
     */
    protected function parseUrl(array $url)
    {
        $this->setUrl($url['raw']);
    }

    /**
     * @param string $url
     */
    protected function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        $writer->code($this->url);

        return $writer->toString();
    }
}