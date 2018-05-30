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
     * @param string $type
     */
    public function convert(string $type): void
    {
        /**
         * @var \App\Writer\Markdown|\App\Writer\Html|\App\Writer\Docx $writer
         */
        $writer = app($type);

        foreach ($this->contents as $item) {
            $writer->anchorLink($item['name'], null, 0);
            $writer->enter();

            if (isset($item['item'])) {
                foreach ($item['item'] as $request)
                    $writer->anchorLink($request['name'], null, 1);

                $writer->enter();
            }
        }
    }
}