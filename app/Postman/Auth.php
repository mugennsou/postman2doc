<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Auth implements Markdownable
{
    public function __construct(array $auth)
    {
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        // TODO: Implement toMarkdown() method.
    }
}