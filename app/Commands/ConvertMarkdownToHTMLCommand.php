<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class ConvertMarkdownToHTMLCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:html
                                        {file? : The markdown file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert markdown to HTML.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {

    }
}
