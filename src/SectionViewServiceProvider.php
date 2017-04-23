<?php
namespace Kamrava\Spf;

use Illuminate\Support\ServiceProvider;
use App;

class SectionViewServiceProvider extends ServiceProvider
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
        App::bind('sectionview', function()
        {
            return new \Kamrava\Spf\SectionView;
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
