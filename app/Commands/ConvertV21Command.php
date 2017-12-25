<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertV21Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert21
                                    {file : The postman collection version 2.1.0 filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection to markdown.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
    }
}
