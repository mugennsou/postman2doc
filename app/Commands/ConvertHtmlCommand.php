<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertHtmlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:html
                                        {file? : The postman collection filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection.json to markdown.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->call('convert', [
            'file'    => $this->argument('file'),
            '--html'  => true,
            '--no-md' => true,
        ]);
    }
}
