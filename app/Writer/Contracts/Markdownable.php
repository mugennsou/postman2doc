<?php

namespace App\Writer\Contracts;

interface Markdownable
{
    /**
     * @return string
     */
    public function toMarkdown(): string;
}