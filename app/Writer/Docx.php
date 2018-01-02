<?php

namespace App\Writer;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\JcTable;


class Docx
{
    protected const SIZE = 8;

    /**
     * @var PhpWord
     */
    protected $word;

    /**
     * @var \PhpOffice\PhpWord\Writer\WriterInterface
     */
    protected $generator;

    /**
     * @var boolean
     */
    protected $converted = false;

    protected $h = [
        6 => 1,
        5 => 1.25,
        4 => 1.5,
        3 => 1.75,
        2 => 2,
        1 => 2.5,
    ];

    /**
     * Docx constructor.
     * @param PhpWord $word
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function __construct(PhpWord $word)
    {
        $this->word      = $word;
        $this->generator = IOFactory::createWriter($this->word);

        $this->initWord();
    }

    protected function initWord()
    {
        foreach ($this->h as $depth => $h)
            $this->word->addTitleStyle($depth, [
                'bold' => true,
                'size' => static::SIZE * $h
            ]);
    }

    /**
     * @return \PhpOffice\PhpWord\Element\Section
     */
    protected function getLastSection(): Section
    {
        $sections = $this->word->getSections();

        return empty($sections) ? $this->word->addSection() : $sections[0];
    }

    /**
     * @param string $content
     */
    public function word(string $content): void
    {
        $this->getLastSection()->addText($content);
    }

    /**
     * @param string $content
     */
    public function line(string $content): void
    {
        $this->word($content);
        $this->enter();
    }

    /**
     * @param int $lines
     */
    public function enter(int $lines = 1): void
    {
        $this->getLastSection()->addTextBreak($lines);
    }

    /**
     * @param string $content
     * @param int $h
     */
    public function h(string $content, int $h = 1): void
    {
        if ($this->isH($h)) {
            $this->getLastSection()->addTitle($content, $h);
            $this->enter();
        } else
            $this->line($content);
    }

    /**
     * @param string $content
     * @param string $url
     * @param int|null $h
     */
    public function link(string $content, string $url, int $h = null): void
    {
        $this->getLastSection()->addLink($url, $content, [
            'bold' => true,
            'size' => static::SIZE * $this->h[$h],
        ]);
    }

    /**
     * @param string $content
     * @param string|null $index
     * @param int|null $h
     */
    public function anchor(string $content, string $index = null, int $h = null): void
    {
        $index = $index ?? app('pinyin')->permalink($content);

        $this->getLastSection()->addBookmark($index);

        $this->isH($h) ? $this->h($content) : $this->line($content);
    }

    /**
     * @param string $content
     * @param string|null $index
     * @param int|null $h
     */
    public function anchorLink(string $content, string $index = null, int $h = null): void
    {
        $index = $index ?? app('pinyin')->permalink($content);

        $this->getLastSection()->addLink(
            $index,
            $content,
            ['bold' => true, 'size' => static::SIZE * $this->h[$h]],
            null,
            true
        );
    }

    /**
     * @param string $content
     * @param bool $multi
     */
    public function code(string $content, bool $multi = false): void
    {
        $section = $this->getLastSection();

        if ($multi) {
            $section->addTextBreak();

            $texts = explode("\n", $content);

            foreach ($texts as $text) {
                $section->addText($text, null, [
                    'widowControl' => false,
                    'indentation'  => ['left' => 240, 'right' => 10]
                ]);
            }
        } else
            $section->addText($content, ['color' => 'ff0000', 'bgColor' => 'c0c0c0']);
    }

    /**
     *
     */
    public function dividingLine(): void
    {
        // $this->getLastSection()->addPageBreak();
        $this->getLastSection()->addLine([
            'width'       => Converter::cmToPixel(15),
            'height'      => Converter::cmToPixel(0),
            'positioning' => 'absolute',
        ]);
    }

    /**
     * @param array $headers
     * @param array $rows
     * @param string $align
     */
    public function table(array $headers, array $rows, string $align = 'left'): void
    {
        $table = $this->getLastSection()->addTable([
            'borderSize'  => 6,
            'borderColor' => '006699',
            'cellMargin'  => 80,
            'alignment'   => JcTable::START
        ]);

        $table->addRow();
        foreach ($headers as $header)
            $table->addCell(2000)->addText($header, ['bold' => true]);

        unset($header);

        foreach ($rows as $row) {
            $table->addRow();

            foreach ($headers as $header)
                $table->addCell(2000)->addText($row[$header] ?? '-');
        }

    }

    /**
     * @param int|null $h
     * @return bool
     */
    protected function isH(int $h = null): bool
    {
        return is_int($h) && $h > 0 && $h < 7;
    }

    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        $this->generator->save("{$path}.docx");
    }
}
