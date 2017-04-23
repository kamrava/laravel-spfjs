<?php

namespace Kamrava\Laravel_SPF;

use Illuminate\Support\ServiceProvider;
use App;

class PartialViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishAssets();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('partialview', function()
        {
            return new \Kamrava\Laravel_SPF\PartialView;
        });
    }

    /**
     * Publish public assets.
     */
    protected function publishAssets()
    {
        $this->publishes([
            realpath(__DIR__.'/../public') => public_path('vendor/laravel-spf'),
        ], 'public');
    }
}
