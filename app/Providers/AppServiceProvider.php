<?php

namespace App\Providers;


use App\Markdown\Writer;
use Illuminate\Support\ServiceProvider;
use Overtrue\Pinyin\Pinyin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('writer', function () {
            return new Writer();
        });

        $this->app->singleton('pinyin', Pinyin::class);
    }
}
