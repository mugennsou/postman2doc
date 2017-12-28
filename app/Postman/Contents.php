<?php

namespace App\Postman;


use App\Markdown\Markdownable;

class Contents implements Markdownable
{
    protected $contents = [];

    public function __construct(array $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        foreach ($this->contents as $item) {
            $writer->anchorLink($item['name'], null, 3);

            if (isset($item['item']))
                foreach ($item['item'] as $request)
                    $writer->anchorLink($request['name'], null, 4);
        }

        return $writer->toString();
    }
}