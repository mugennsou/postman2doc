<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Url extends AbstractConvert
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
        $markdown = app('markdown');

        $markdown->code($this->url);

        return $markdown->toString();
    }

    /**
     * Convert to docx.
     */
    public function toDocx(): void
    {
        /**
         * @var \App\Writer\Docx $docx
         */
        $docx = app('docx');
    }
}