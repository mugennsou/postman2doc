<?php

namespace App\Postman;

trait CollectionTrait
{
    /**
     * @var string|array
     */
    protected $raw;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /*
    * string|array $raw
    */
    protected function setRaw($raw): void
    {
        $this->raw = $raw;
    }

    /**
     * @param string $name
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }
}