<?php

namespace App\Writer\Contracts;

interface Htmlable
{
    /**
     * @return string
     */
    public function toHtml(): string;
}