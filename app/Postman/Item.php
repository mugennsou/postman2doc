<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Item extends AbstractCollection implements Markdownable
{
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
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        $writer->anchor($this->name, null, is_null($this->request) ? 3 : 4);

        !empty($this->description) && $writer->line($this->description);

        if (is_null($this->request)) {
            foreach ($this->item as $item)
                $writer->word($item->toMarkdown());
        } else {
            $writer->h('REQUEST', 4);
            $writer->enter();
            $writer->word($this->request->toMarkdown());

            if (count($this->response)) {
                $writer->h('RESPONSES', 4);
                foreach ($this->response as $response)
                    $writer->word($response->toMarkdown());
            }

            $writer->dividingLine();
        }

        return $writer->toString();
    }
}