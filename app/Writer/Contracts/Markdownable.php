<?php

namespace App\Writer\Contracts;

interface Markdownable
{
    public function toMarkdown(): void;
}