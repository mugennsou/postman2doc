<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Auth implements Markdownable
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