<?php

namespace App\Writer;

use App\Writer\Contracts\Docxable;
use App\Writer\Contracts\Htmlable;
use App\Writer\Contracts\Markdownable;

abstract class AbstractConvert implements Markdownable, Htmlable, Docxable
{
    /**
     * @return string
     */
    public function toHtml(): string
    {
        $html = app('html');

        $html->markdown($this->toMarkdown());

        return $html->toString();
    }
}