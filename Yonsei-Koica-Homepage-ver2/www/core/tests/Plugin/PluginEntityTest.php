<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Mockery;
use Mockery\MockInterface;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginEntity;

class PluginEntityTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $entity = new PluginEntity(
            'plugin_sample',
            __DIR__.'/plugins/plugin_sample/plugin.php',
            '\Xpressengine\Tests\Plugin\Sample\PluginSample',
            $this->getMetaData()
        );


        $this->assertInstanceOf('\Xpressengine\Plugin\PluginEntity', $entity);

        return $entity;
    }


    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetId($entity)
    {
        $this->assertEquals('plugin_sample', $entity->getId());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetClass($entity)
    {
        $this->assertEquals('\Xpressengine\Tests\Plugin\Sample\PluginSample', $entity->getClass());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetObejct($entity)
    {
        $plugin = $entity->getObject();
        $this->assertInstanceOf('\Xpressengine\Tests\Plugin\Sample\PluginSample', $plugin);

        Mockery::mock(
            'alias:Component',
            '\Xpressengine\Plugin\ComponentInterface',
            [
                'setId' => null,
                'setComponentInfo' => null,
            ]
        );

        return $plugin;
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testCheckUpdate($entity)
    {
        $entity->setInstalledVersion('2.0.0');
        $this->assertFalse($entity->checkUpdate());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testToArray($entity)
    {
        $this->assertEquals('plugin_sample', $entity->toArray()['id']);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetMetaData($entity)
    {
        $meta = $entity->getMetaData();
        $this->assertEquals('2.0.1', $meta['version']);

        $version = $entity->getMetaData('version');
        $this->assertEquals('2.0.1', $version);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetComponentList($entity)
    {
        $components = $entity->getComponentList();

        $this->assertEquals('?????????', $components['module/board']['name']);

        $modules = $entity->getComponentList('module');

        $this->assertCount(2, $modules);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetters($entity)
    {
        $this->assertEquals('title',$entity->getTitle());
        $this->assertEquals('sample plugin.', $entity->getDescription());
        $this->assertCount(6, $entity->getSupport());
        $this->assertEquals('xe/plugin_sample', $entity->getName());
        $this->assertEquals(['xpressengine', 'board'], $entity->getKeywords());
        $this->assertEquals('xe',$entity->getAuthors()[0]['name']);
        $this->assertEquals('LGPL-2.0',$entity->getLicense());
    }

    private function getMetaData()
    {
        return json_decode(
            '{
                      "name": "xe/plugin_sample",
                      "description": "sample plugin.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
                      "version": "2.0.1",
                      "support": {
                        "email": "contact@xpressengine.com",
                        "issues": "http://myproject.com/issues",
                        "forum": "http://myproject.com/forum",
                        "wiki": "http://myproject.com/wiki",
                        "irc": "http://myproject.com/irc",
                        "source": "http://myproject.com/source/"
                      },
                      "authors": [
                        {
                          "name": "xe",
                          "email": "contact@xpressengine.com",
                          "homepage": "https://xpressengine.io",
                          "role": "Developer"
                        }
                      ],
                      "license": "LGPL-2.0",
                      "type": "xpressengine-plugin",
                      "extra": {
                        "xpressengine": {
                          "title": "title",
                          "component": {
                            "module/board": {
                              "class": "XE\\\PluginA\\\Modules\\\Board",
                              "name": "?????????",
                              "description": "??????????????????."
                            },
                            "module/board/sortingType/default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\SortType",
                              "name": "????????? ??????????????????",
                              "description": "???????????? ?????? ?????????????????????."
                            },
                            "module/board/skin/default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\Skins\\\Base",
                              "name": "????????? ????????????",
                              "description": "????????? ?????????????????????."
                            },
                            "module/xe_forum": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum",
                              "name": "??????",
                              "description": "???????????????."
                            },
                            "module/forum/skin/sketchbook": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "????????? ??????????????????",
                              "description": "????????? ???????????????????????????."
                            },
                            "uiobject/phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "fieldType/phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "widget/content/skin/sketchbookBase": {
                              "class": "XE\\\PluginA\\\Widgets\\\Kboard",
                              "name": "kboard",
                              "description": "kboard ????????? ??????"
                            }
                          }
                        }
                      },
                      "autoload": {
                        "psr-4": {
                          "XE\\\Kboard\\\": "plugins/kboard"
                        },
                        "files": [
                          "core/src/Xpressengine/Interception/helpers.php"
                        ]
                      },
                      "repositories": [
                        {
                          "type": "composer",
                          "url": "http://packagist.test4.xehub.kr"
                        }
                      ],
                      "require": {
                        "xe3/ncenter": "*"
                      }
                    }',
            true
        );
    }

}

