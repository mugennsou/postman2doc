<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Auth extends AbstractConvert
{
    public function __construct(array $auth)
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