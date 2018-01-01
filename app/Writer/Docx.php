<?php

namespace App\Writer;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;


class Docx
{
    /**
     * @var PhpWord
     */
    protected $word;

    /**
     * @var \PhpOffice\PhpWord\Writer\WriterInterface
     */
    protected $generator;

    protected $converted;

    /**
     * Docx constructor.
     * @param PhpWord $word
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function __construct(PhpWord $word)
    {
        $this->word = $word;

        $this->generator = IOFactory::createWriter($this->word);
    }

    /**
     * @return \PhpOffice\PhpWord\Element\Section
     */
    public function getLastSection(): Section
    {
        $sections = $this->word->getSections();

        return empty($sections) ? $this->word->addSection() : $sections[0];
    }

    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        $this->generator->save("{$path}.docx");
    }
}
