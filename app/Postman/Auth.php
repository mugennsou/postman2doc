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