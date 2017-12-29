<?php

namespace App\Writer;


use App\Postman\Collection;

class Convert
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $supportExt = [
        'markdown',
        'html',
    ];

    /**
     * Convert constructor.
     * @param Collection|null $collection
     */
    public function __construct(Collection $collection = null)
    {
        is_null($collection) || $this->setCollection($collection);
    }

    /**
     * @param Collection $collection
     * @return Convert
     */
    public function setCollection(Collection $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Convert file.
     * @param string $path
     * @param string|array $type
     */
    public function output(string $path, $type): void
    {
        if (is_string($type) && in_array($type, $this->supportExt)) {

            $type   = strtolower($type);
            $action = 'to' . ucfirst($type);

            file_put_contents("{$path}.{$type}", $this->collection->{$action}());
        } elseif (is_array($type)) {

            foreach ($type as $ext) $this->output($path, $ext);
        }
    }
}