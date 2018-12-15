<?php
namespace Searching\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * 服务提供者
 */
class SearchingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(dirname(__FILE__) . '/../../src/routes/search.php');

        $this->publishes([
            dirname(__FILE__) . '/../../publishes/' => base_path(),
        ], 'searching');
    }

    /**
     * Load the given routes file if routes are not already cached.
     *
     * @param  string  $path
     * @return void
     */
    protected function loadRoutesFrom($path)
    {
        if (!$this->app->routesAreCached()) {
            require $path;
        }
    }
}
