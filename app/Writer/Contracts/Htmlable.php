<?php

namespace App\Writer\Contracts;

interface Htmlable
{
    /**
     * To html.
     */
    public function toHtml(): void;
}