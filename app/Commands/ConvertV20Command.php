<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertV20Command extends Command
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->warn('I am working for v2.0.0, please stay tuned for updates.');
    }
}
