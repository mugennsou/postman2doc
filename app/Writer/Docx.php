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

    /**
     * Docx constructor.
     * @param PhpWord $word
     * @param IOFactory $factory
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function __construct(PhpWord $word, IOFactory $factory)
    {
        $this->word = $word;

        $this->generator = IOFactory::createWriter($this->word);
    }

    /**
     * @return \PhpOffice\PhpWord\Element\Section
     */
    public function getSection(): Section
    {
        $sections = $this->word->getSections();

        return empty($sections) ? $this->word->addSection() : $sections[0];
    }
}
