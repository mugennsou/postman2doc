<?php

namespace App\Markdown;

interface Markdownable
{
    /**
     * @return string
     */
    public function toMarkdown(): string;
}