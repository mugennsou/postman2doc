<?php

namespace App\Providers;


use App\Markdown\Writer;
use Parsedown;
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

        $this->app->singleton('parsedown', Parsedown::class);

        $this->app->singleton('pinyin', Pinyin::class);
    }
}
