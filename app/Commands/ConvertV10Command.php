<?php

namespace App\Commands;

class ConvertV10Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert10
                                    {file : The postman collection version 1.0.0 filename}
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
    protected $version = 'v1.0.0';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->warn('I am working for v1.0.0, please stay tuned for updates.');
    }
}
