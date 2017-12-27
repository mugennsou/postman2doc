<?php

namespace App\Commands;

class ConvertV20Command extends ConvertV21Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert20
                                    {file : The postman collection version 2.0.0 filename}
                                    {output : Output file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection to markdown.';

    /**
     * @var string
     */
    protected $version = 'v2.0.0';

    protected function parseUrl(string $method, $url): void
    {
        $url = is_array($url) ? $url['raw'] : $url;

        $this->writeH('URL', 5);
        $this->writeCode($method);
        $this->writeCode($url);
        $this->writeEnter();
    }
}
