<?php

namespace Tests\Postman2doc;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConvertDocxTest extends TestCase
{
    /**
     * Test convert.
     */
    public function testConvertedFile()
    {
        $testFile = storage_path("app/postman_collection.json");

        $this->app->call('convert:docx', [
            'file' => $testFile
        ]);

        $this->assertFileExists(storage_path("app/postman_collection.json.docx"));
    }

    public static function tearDownAfterClass()
    {
        Storage::delete('postman_collection.json.docx');
    }
}