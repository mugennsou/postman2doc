<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Contents extends AbstractConvert
{
    protected $contents = [];

    public function __construct(array $contents)
    {
        $this->contents = $contents;
    }

    /**
     * To markdown
     */
    public function toMarkdown(): void
    {
        $markdown = app('markdown');

        foreach ($this->contents as $item) {
            $markdown->anchorLink($item['name'], null, 3);

            if (isset($item['item']))
                foreach ($item['item'] as $request)
                    $markdown->anchorLink($request['name'], null, 4);
        }
    }

    /**
     * Convert to docx.
     */
    public function toDocx(): void
    {
        /**
         * @var \App\Writer\Docx $docx
         */
        $docx = app('docx');
    }
}