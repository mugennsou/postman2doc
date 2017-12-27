<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    public function abort(string $error)
    {
        dd("exit - {$error}");
    }
}
