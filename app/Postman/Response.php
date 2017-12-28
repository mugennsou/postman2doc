<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Response implements Markdownable
{
    public function __construct(array $response)
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