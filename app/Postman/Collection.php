<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Collection extends AbstractCollection implements Markdownable
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var Item[]
     */
    protected $item = [];

    /**
     * @var Contents
     */
    protected $contents;

    /**
     * Collection constructor.
     * @param array $collection
     * @throws Exception
     */
    public function __construct(array $collection)
    {
        if (isset($collection['info']) && isset($collection['item'])) {
            $this->setInfo($collection['info']);

            $this->setContents($this->parseContents($collection['item']));

            $this->setItem($collection['item']);
        }
    }

    /**
     * @param array $info
     * @throws Exception
     */
    protected function setInfo(array $info): void
    {
        $this->setName($info['name']);

        $this->setDescription($info['description']);

        $this->setVersion($this->parseVersion($info['schema']));
    }

    /**
     * @param string $version
     */
    protected function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param array $contents
     */
    protected function setContents(array $contents): void
    {
        $this->contents = new Contents($contents);
    }

    /**
     * @param array $items
     */
    protected function setItem(array $items): void
    {
        foreach ($items as $item) {
            $this->item[] = new Item($item);
        }
    }

    /**
     * @param string $schema
     * @return string
     * @throws Exception
     */
    protected function parseVersion(string $schema): string
    {
        if (str_contains($schema, 'v2.0.0'))
            return 'v2.0.0';

        elseif (str_contains($schema, 'v2.1.0'))
            return 'v2.1.0';

        else
            throw new Exception('Unknown collection version.');
    }

    /**
     * @param array $items
     * @return array
     */
    protected function parseContents(array $items): array
    {
        $contents = [];

        foreach ($items as $key => $item) {
            $contents[$key] = ['name' => $item['name']];

            if (isset($item['item']) && is_array($item['item'])) {
                $contents[$key]['item'] = [];

                foreach ($item['item'] as $request)
                    $contents[$key]['item'][] = ['name' => $request['name']];
            }
        }

        return $contents;
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        $writer->h($this->name);

        !empty($this->description) && $writer->line($this->description);

        $writer->enter();

        $writer->h('Contents', 2);
        $writer->enter();
        $writer->word($this->contents->toMarkdown());

        $writer->enter();

        $writer->h('Body', 2);
        $writer->enter();
        foreach ($this->item as $item)
            $writer->word($item->toMarkdown());

        return $writer->toString();
    }
}
