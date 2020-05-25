<?php
/*
 * laravel-packages - AbstractUserProviderServiceProvider.php
 * Initial version by : murataygun
 * Initial version created on : 13.5.2020 01:13
 */

namespace murataygun\UserProvider;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AbstractGrant;
use ReflectionClass;

/**
 * Class AbstractUserProviderServiceProvider
 * @author Murat AYGÜN <info@murataygun.com>
 * @package murataygun\UserProvider
 */
abstract class AbstractUserProviderServiceProvider extends PassportServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getDir() . '/config/user-provider-' . $this->getIdentifier() . '.php', 'user-provider-' . $this->getIdentifier());
        app()->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $server->enableGrantType(
                $this->makeGrant(), Passport::tokensExpireIn()
            );
        });
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    private function getDir()
    {
        $reflector = new ReflectionClass(get_class($this));
        $filename = $reflector->getFileName();
        return dirname($filename);
    }

    /**
     * Create and configure a Password grant instance.
     *s
     * @return AbstractGrant
     */
    abstract protected function makeGrant();

    /**
     * @return mixed
     */
    abstract protected function getIdentifier();

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getDir() . '/config/user-provider-' . $this->getIdentifier() . '.php' => config_path('user-provider-' . $this->getIdentifier() . '.php')
        ], 'config');
    }
}
