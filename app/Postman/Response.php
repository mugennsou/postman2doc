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
     * @return string
     */
    public function toMarkdown(): string
    {
        return '';
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