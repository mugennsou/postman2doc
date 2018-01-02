<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Item extends AbstractConvert
{
    use CollectionTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response[]
     */
    protected $response = [];

    /**
     * @var Item[]
     */
    protected $item = [];

    /**
     * Item constructor.
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->parseItem($item);
    }

    /**
     * @param array $item
     */
    protected function parseItem(array $item): void
    {
        $this->setRaw($item);

        $this->setName($item['name']);

        if (isset($item['item'])) {
            $this->setItem($item['item']);
            isset($item['description']) && $this->setDescription($item['description']);
        }

        if (isset($item['request'])) {
            $this->setRequest($item['request']);
            isset($item['response']) && $this->setResponse($item['response']);
        }
    }

    /**
     * @param array $items
     */
    protected function setItem(array $items)
    {
        foreach ($items as $item) {
            $this->item[] = new Item($item);
        }
    }

    /**
     * @param array $request
     */
    protected function setRequest(array $request): void
    {
        $this->request = new Request($request);
    }

    /**
     * @param array $responses
     */
    protected function setResponse(array $responses): void
    {
        foreach ($responses as $response) {
            $this->response[] = new Response($response);
        }
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

        $writer->anchor($this->name, null, is_null($this->request) ? 3 : 4);

        !empty($this->description) && $writer->line($this->description);

        if (is_null($this->request)) {
            foreach ($this->item as $item) $item->convert($type);
        } else {
            $writer->h('REQUEST', 4);
            $writer->enter();
            $this->request->convert($type);

            if (count($this->response)) {
                $writer->h('RESPONSES', 4);
                foreach ($this->response as $response) $response->convert($type);
            }

            $writer->dividingLine();
        }
    }
}