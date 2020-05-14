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
        $this->mergeConfig();
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
        $this->publishConfig();
    }

    private function getDir()
    {
        $reflector = new ReflectionClass(get_class($this));
        $filename = $reflector->getFileName();
        return dirname($filename);
    }

    private function publishConfig()
    {
        $configPath = $this->getDir() . '/config';
        $configFiles = array_diff(scandir($configPath), array('.', '..'));

        foreach ($configFiles as $configFile) {
            $this->publishes([
                $configPath . '/' . $configFile => config_path($configFile)
            ], 'config');
        }
    }

    private function mergeConfig()
    {
        $configPath = $this->getDir() . '/config';
        $configFiles = array_diff(scandir($configPath), array('.', '..'));

        foreach ($configFiles as $configFile) {
            $this->mergeConfigFrom($configPath . '/' . $configFile, str_replace(".php", "", $configFile));
        }
    }
}
