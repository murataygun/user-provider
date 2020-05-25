<?php
/*
 * laravel-packages - AbstractUserProviderServiceProvider.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 01:13
 */

namespace murataygun\UserProvider;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AbstractGrant;
use ReflectionClass;

/**
 * Class AbstractUserProviderServiceProvider
 * @author Murat AYGÜN <info@murataygun.com>
 * @package murataygun\UserProvider
 */
abstract class AbstractUserProviderServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/user-provider-' . $this->makeGrant()->getIdentifier() . '.php', 'user-provider-' . $this->makeGrant()->getIdentifier());
        app()->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $server->enableGrantType(
                $this->makeGrant(), Passport::tokensExpireIn()
            );
        });
    }

    /**
     * Create and configure a Password grant instance.
     *s
     * @return AbstractGrant
     */
    abstract protected function makeGrant();

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/user-provider-' . $this->makeGrant()->getIdentifier() . '.php' => config_path('user-provider-' . $this->makeGrant()->getIdentifier() . '.php')
        ], 'config');
    }
}
