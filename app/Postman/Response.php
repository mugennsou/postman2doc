<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Response extends AbstractConvert
{
    public function __construct(array $response)
    {
    }

    /**
     * TODO:
     * @param string $type
     */
    public function convert(string $type): void
    {
        /**
         * @var \App\Writer\Markdown|\App\Writer\Html|\App\Writer\Docx $writer
         */
        $writer = app($type);
    }
}