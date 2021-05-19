<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Xpressengine\Routing\UriValidator;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;

/**
 * Class UriValidatorTest
 *
 * @package Xpressengine\Tests\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UriValidatorTest extends TestCase
{
    /**
     * @var
     */
    protected $uriValidator;

    /**
     * @var
     */
    protected $route;
    /**
     * @var
     */
    protected $request;

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
     * testRootUri
     *
     * @return void
     */
    public function testRootUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var UriValidator $uriValidator;
         */
        $route = $this->route;

        $request = $this->request;
        $request->shouldReceive('path')->andReturn('/');
        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');

        $uriValidator = $this->uriValidator;

        $result = $uriValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    /**
     * testHomeUri
     *
     * @return void
     */
    public function testHomeUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var UriValidator $uriValidator;
         */
        $route = $this->route;
        $route->shouldReceive('getCompiled')->andReturn($route);
        $route->shouldReceive('getRegex')->andReturn("#^/home$#s");

        $request = $this->request;
        $request->shouldReceive('decodedPath')->andReturn('home');
        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');

        $uriValidator = $this->uriValidator;

        $result = $uriValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        /**
         * @var Route           $route
         * @var Request     $request
         */
        $route = m::mock('Illuminate\Routing\Route');
        $request = m::mock('Illuminate\Http\Request');

        $uriValidator = new UriValidator();
        $this->uriValidator = $uriValidator;

        $this->route = $route;
        $this->request = $request;


        parent::setUp();
    }
}
