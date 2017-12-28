<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Header implements Markdownable
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
        $writer = app('writer');

        $writer->table($this->headerTitle, $this->header);

        return $writer->toString();
    }
}