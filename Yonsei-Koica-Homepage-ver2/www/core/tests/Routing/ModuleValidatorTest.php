<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\InstanceRouteHandler;
use Xpressengine\Routing\ModuleValidator;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Xpressengine\Routing\RouteCollection;

/**
 * Class ModuleValidatorTest
 *
 * @package Xpressengine\Tests\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ModuleValidatorTest extends TestCase
{
    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testHomeStaticRouteUri
     *
     * @return void
     */
    public function testHomeStaticRouteUri()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('');
        $route->shouldReceive('getAction')->andReturn([]);


        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    /**
     * testRootNotMatchUri
     *
     * @return void
     */
    public function testRootNotMatchUri()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(false, $result);
    }

    /**
     * testRootMatchUri
     *
     * @return void
     */
    public function testRootMatchUri()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/xpressengine@board'
        ]);

        $route->shouldReceive('setAction')->andReturn($route);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(false, $result);
    }

    /**
     * testAboutUsNotMatchUri
     *
     * @return void
     */
    public function testAboutUsNotMatchUri()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('aboutus');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);

    }

    /**
     * testAboutUsNotMatchUriNoModuleAttr
     *
     * @return void
     */
    public function testAboutUsNotMatchUriNoModuleAttr()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([

        ]);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);

    }

    /**
     * testBoardMatchUri
     *
     * @return void
     */
    public function testBoardMatchUri()
    {
        list($routeRepo, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();
        
        $request->shouldReceive('segment')->with(1)->andReturn('board');
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/pluginB@page'
        ]);

        $route->shouldReceive('uri')->andReturn('freeboard');
        $route->shouldReceive('setAction')->andReturn($route);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Routing\RouteRepository'),
            m::mock('Xpressengine\Site\SiteHandler'),
            m::mock('Illuminate\Routing\Route'),
            m::mock('Illuminate\Http\Request'),
        ];
    }
}
