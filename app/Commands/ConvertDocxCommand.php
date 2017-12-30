<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertDocxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:docx
                                        {file? : The postman collection filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection.json to docx.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->call('convert', [
            'file'    => $this->argument('file'),
            '--docx'  => true,
            '--no-md' => true,
        ]);
    }
}
