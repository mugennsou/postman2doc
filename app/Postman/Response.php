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
     * To markdown
     */
    public function toMarkdown(): void
    {
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