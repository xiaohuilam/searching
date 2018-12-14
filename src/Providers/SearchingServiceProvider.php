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
}
