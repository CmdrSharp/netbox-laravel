<?php

namespace CmdrSharp\NetBox;

use CmdrSharp\NetBox\Contracts\NetBoxInterface;
use Illuminate\Support\ServiceProvider;

class NetBoxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('netbox.php'),
        ], 'netbox-config');
    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(NetBoxInterface::class, NetBoxServiceProvider::class);
    }
}
