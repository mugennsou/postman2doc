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
     * @param string $type
     */
    public function convert(string $type): void
    {
        /**
         * @var \App\Writer\Markdown|\App\Writer\Html|\App\Writer\Docx $writer
         */
        $writer = app($type);

        $writer->code($this->url);
    }
}