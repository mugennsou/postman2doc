<?php

namespace App\Writer\Contracts;

interface Docxable
{
    /**
     * Convert to docx.
     */
    public function toDocx(): void;
}
