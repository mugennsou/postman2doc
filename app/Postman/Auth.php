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
}