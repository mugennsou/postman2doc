<?php

namespace Tests\Postman2doc;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConvertMarkdownTest extends TestCase
{
    /**
     * Test convert.
     */
    public function testConvertedFile()
    {
        $testFile = storage_path("app/postman_collection.json");

        $this->app->call('convert', [
            'file' => $testFile
        ]);

        $this->assertFileExists(storage_path("app/postman_collection.json.markdown"));
    }

    /**
     * @return string
     */
    public function testConvertedFileContent(): string
    {
        $content = Storage::get("postman_collection.json.markdown");

        $this->assertTrue(mb_strlen($content) > 0);

        return $content;
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedInfo(string $content)
    {
        $this->assertContains('# Postman Echo', $content);
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedContents(string $content)
    {
        $this->assertContains('### [Response Status Code](#Response-Status-Code)', $content);
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedRequest(string $content)
    {
        $this->assertContains('`https://postman-echo.com/status/200`', $content);
    }

    public static function tearDownAfterClass()
    {
        Storage::delete('postman_collection.json.markdown');
    }
}