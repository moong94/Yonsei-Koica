<?php
/**
 * RoutingServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Closure;
use Illuminate\Routing\Matching\HostValidator;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\ModuleValidator;
use Xpressengine\Routing\Repositories\CacheDecorator;
use Xpressengine\Routing\Repositories\DatabaseRouteRepository;
use Xpressengine\Routing\Repositories\MemoryDecorator;
use Xpressengine\Routing\RouteCollection;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Routing\UriValidator;

/**
 * Class RoutingServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $routeValidator = Route::getValidators();
        $routeValidator['module']->boot($this->app['xe.router'], $this->app['xe.site']);

        $this->app['events']->listen('Illuminate\Routing\Events\RouteMatched', function ($event) {
            if ($module = $event->route->getAction('module')) {
                $routes = $this->app['xe.router']->fetchByModule($module);
                $instanceRoute = collect($routes)->filter(function ($route) use ($event) {
                    $segment = $event->request->segment(1);
                    return $route->url === $segment ||
                        (!$segment && $this->app['xe.site']->getHomeInstanceId() === $route->instance_id);
                })->first();

                $item = $this->app['xe.menu']->items()->find($instanceRoute->instance_id);
                $menuConfig = $this->app['xe.menu']->getMenuItemTheme($item);
                $theme = $menuConfig->get($event->request->isMobile() ? 'mobileTheme' : 'desktopTheme');

                $instanceConfig = \Xpressengine\Routing\InstanceConfig::instance();
                $instanceConfig->setTheme($theme);
                $instanceConfig->setInstanceId($instanceRoute->instance_id);
                $instanceConfig->setModule($module);
                $instanceConfig->setUrl($instanceRoute->url);
                $instanceConfig->setMenuItem($item);

                $this->app['xe.theme']->selectTheme($theme);
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RouteRepository::class, function ($app) {
            $repo = new DatabaseRouteRepository($app['config'], InstanceRoute::class);

            if ($app['config']['app.debug'] !== true) {
                $repo = new CacheDecorator($repo, $app['cache.store']);
            }

            return new MemoryDecorator($repo);
        });
        $this->app->alias(RouteRepository::class, 'xe.router');

        /*
         * RouteServiceProvider ??? ?????? boot ???????????????
         * boot ??? ?????? register ?????? ??????
         */
        $this->setNewRouteValidator();
        $this->registerMacro($this->app['router']);
        $this->registerRouteCollection($this->app['router']);
    }

    /**
     * Set New Route Validator
     *
     * Route ??? ???????????? matching ?????? ???????????? ????????? ??? ?????? validator ??? ???????????? ??????
     * ???????????? ????????? Xe ??? ???????????? Route ??? ???????????? ????????? Validator ??? ?????????
     *
     * @return void
     */
    public function setNewRouteValidator()
    {
        Route::$validators = [
            'method' => new MethodValidator,
            'scheme' => new SchemeValidator,
            'host' => new HostValidator,
            'uri' => new UriValidator,
            'module' => new ModuleValidator
        ];
    }

    /**
     * Register Route Macro
     * XE ????????? ????????? Route Macro ?????? ???????????????.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    public function registerMacro(Router $router)
    {
        $this->registerFixedMacro($router);
        $this->registerSettingsMacro($router);
        $this->registerInstanceMacro($router);

    }

    /**
     * Register Router Macro called Settings
     * settings ??? ????????? ??? ?????? Router ???????????? ????????????
     * ????????? ui ??? ??????????????? ???????????? ????????? ??? ??????.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerSettingsMacro(Router $router)
    {
        $manageMacro = function ($key, Closure $callback, $routeOptions = null) {

            $key = str_replace('.', '/', $key);

            $attributes = [
                'prefix' => config('xe.routing.settingsPrefix') . '/' . $key,
                'middleware' => ['web', 'settings']
            ];

            if ($routeOptions !== null and is_array($routeOptions)) {
                $routeOptions = array_except($routeOptions, ['prefix']);
                $attributes = array_merge($attributes, $routeOptions);
            }

            $this->group($attributes, $callback);
        };

        $router->macro('settings', $manageMacro);
    }

    /**
     * Register Router Macro called Fixed
     * fixed ??? ????????? ??? ?????? Router ???????????? ????????????
     * ???????????? ????????? URL ??? ????????? ??? ????????? ??????.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerFixedMacro(Router $router)
    {
        $fixedMacro = function ($key, Closure $callback, $routeOptions = null) {

            $newKey = str_replace('@', '/', $key);

            $attributes = [
                'prefix' => config('xe.routing.fixedPrefix') . '/' . $newKey,
                'middleware' => ['web']
            ];

            if ($routeOptions !== null and is_array($routeOptions)) {
                $routeOptions = array_except($routeOptions, ['prefix']);
                $attributes = array_merge($attributes, $routeOptions);
            }

            $this->group($attributes, $callback);
        };

        $router->macro('fixed', $fixedMacro);
    }

    /**
     * Register Router Macro called Instance
     * ????????????????????? ????????? route pattern ????????? ???????????? instance route ??? ?????? ??? ????????? ??????
     * ????????? ??????
     *
     * @param Router $router to register macro
     * @return void
     */
    protected function registerInstanceMacro(Router $router)
    {
        static $seq = 1;
        $instanceMacro = function ($key, Closure $callback, array $routeOptions = null) use (&$seq) {

            $pattern = '{instanceGroup'.$seq++.'}';
            $attributes = [
                'prefix' => $pattern,
                'module' => $key,
                'middleware' => ['web', 'access']
            ];

            if ($routeOptions) {
                $attributes = array_merge(array_except($routeOptions, ['prefix', 'middleware']), $attributes);

                if (isset($routeOptions['middleware'])) {
                    $attributes['middleware'] = array_merge(
                        (array)$routeOptions['middleware'],
                        $attributes['middleware']
                    );
                }
            }

            $router = $this;
            app('events')->listen('booted.plugins', function () use ($router, $attributes, $callback) {
                $router->group($attributes, $callback);
            });
        };

        $router->macro('instance', $instanceMacro);

    }

    /**
     * Register the route collection to the router.
     *
     * @param Router $router to register macro
     * @return void
     */
    protected function registerRouteCollection(Router $router)
    {
        $router->setRoutes(
            new RouteCollection()
        );
    }
}
