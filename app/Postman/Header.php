<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Header extends AbstractConvert
{
    /**
     * @var array
     */
    protected $headerTitle = ['key', 'value', 'description'];

    /**
     * @var array
     */
    protected $header;

    /**
     * Header constructor.
     * @param array $header
     */
    public function __construct(array $header)
    {
        $this->header = $header;
    }

    /**
     * @return boolean
     */
    public function hasHeader(): bool
    {
        return count($this->header) > 0;
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        $markdown = app('markdown');

        $markdown->table($this->headerTitle, $this->header);

        return $markdown->toString();
    }
}