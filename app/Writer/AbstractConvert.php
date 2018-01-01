<?php

namespace App\Writer;

use App\Writer\Contracts\Docxable;
use App\Writer\Contracts\Htmlable;
use App\Writer\Contracts\Markdownable;

abstract class AbstractConvert implements Markdownable, Htmlable, Docxable
{
    /**
     * To html.
     */
    public function toHtml(): void
    {
        $html     = app('html');
        $markdown = app('markdown');

        $this->toMarkdown();
        $html->markdown($markdown->toString());
    }
}