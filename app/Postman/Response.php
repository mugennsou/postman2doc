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
}