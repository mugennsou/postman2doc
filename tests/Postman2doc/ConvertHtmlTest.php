<?php

namespace Tests\Postman2doc;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConvertHtmlTest extends TestCase
{
    /**
     * Test convert.
     */
    public function testConvertedFile()
    {
        $testFile = storage_path("app/postman_collection.json");

        $this->app->call('convert:html', [
            'file' => $testFile
        ]);

        $this->assertFileExists(storage_path("app/postman_collection.json.html"));
    }

    /**
     * @return string
     */
    public function testConvertedFileContent(): string
    {
        $content = Storage::get("postman_collection.json.html");

        $this->assertTrue(mb_strlen($content) > 0);

        return $content;
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedInfo(string $content)
    {
        $this->assertContains("<h1>Postman Echo</h1>", $content);
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedContents(string $content)
    {
        $this->assertContains("<h3><a href=\"#Response-Status-Code\">Response Status Code</a></h3>", $content);
    }

    /**
     * @depends testConvertedFileContent
     * @param string $content
     */
    public function testConvertedRequest(string $content)
    {
        $this->assertContains("<code>https://postman-echo.com/status/200</code>", $content);
    }

    public static function tearDownAfterClass()
    {
        Storage::delete('postman_collection.json.html');
    }
}