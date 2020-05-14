<?php

namespace murataygun\UserProvider;

use Illuminate\Support\ServiceProvider;

class UserProviderServiceProvider extends ServiceProvider{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/user-provider.php', 'user-provider');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/user-provider.php' => config_path('user-provider.php')
        ], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function provides()
    {
        return ['UserProvider'];
    }

}
