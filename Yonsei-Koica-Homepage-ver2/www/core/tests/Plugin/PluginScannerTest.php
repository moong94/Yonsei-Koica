<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginScanner;

class PluginScannerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $base = __DIR__;
        $dir    = __DIR__.'/plugins';
        $reader = $this->getReaderMock($dir);

        $scanner = new PluginScanner($reader, $dir, $base);

        $this->assertInstanceOf('Xpressengine\Plugin\PluginScanner', $scanner);

        return $scanner;
    }

    /**
     * @depends testConstruct
     *
     * @param PluginScanner $scanner
     */
    public function testScanDirectory($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory();

        $this->assertEquals(2, count($pluginsInfos));

        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample', $pluginsInfos['plugin_sample']['class']);
        $this->assertEquals(
            'xe/plugin_sample',
            $pluginsInfos['plugin_sample']['metaData']['name']
        );
        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample2', $pluginsInfos['plugin_sample2']['class']);
        $this->assertEquals(
            'xe/plugin_sample2',
            $pluginsInfos['plugin_sample2']['metaData']['name']
        );
    }

    /**
     * @depends testConstruct
     *
     * @param PluginScanner $scanner
     */
    public function testScanDirectorySpecificPlugin($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory('plugin_sample2');

        $this->assertEquals(1, count($pluginsInfos));

        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample2', $pluginsInfos['plugin_sample2']['class']);
        $this->assertEquals(
            'xe/plugin_sample2',
            $pluginsInfos['plugin_sample2']['metaData']['name']
        );
    }

    /**
     * @depends testConstruct
     * @expectedException \Xpressengine\Plugin\Exceptions\PluginNotFoundException
     * @param PluginScanner $scanner
     */
    public function testScanDirectoryNotExistsPlugin($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory('plugin_sample3');
    }

    public function testScanDirectoryInvalidPluginFile()
    {
        $base = __DIR__;
        $dir    = __DIR__.'/invalid_plugins';
        $reader = $this->getReaderMock($dir);

        $scanner = new PluginScanner($reader, $dir, $base);

        $pluginsInfos = $scanner->scanDirectory();

        $this->assertEmpty($pluginsInfos);
    }

    /**
     * getReaderMock
     *
     * @return \Mockery\MockInterface
     */
    protected function getReaderMock($dir)
    {
        $reader = \Mockery::mock('Xpressengine\Plugin\MetaFileReader');
        $reader->shouldReceive('read')
            ->withArgs([$dir.'/plugin_sample'])
            ->andReturn(
                json_decode(
                '{
                      "name": "xe/plugin_sample",
                      "description": "xe ?????????????????????.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
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
                          "components": {
                            "module|board": {
                              "class": "XE\\\PluginA\\\Modules\\\Board",
                              "name": "?????????",
                              "description": "??????????????????."
                            },
                            "module|board|sortingType|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "????????? ??????????????????",
                              "description": "???????????? ?????? ?????????????????????."
                            },
                            "module|board|skin|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "????????? ????????????",
                              "description": "????????? ?????????????????????."
                            },
                            "module|xe_forum": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum",
                              "name": "??????",
                              "description": "???????????????."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "????????? ??????????????????",
                              "description": "????????? ???????????????????????????."
                            },
                            "uiobject|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "fieldType|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "widget|content|skin|sketchbookDefault": {
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
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );

        $reader->shouldReceive('read')
            ->withArgs([$dir.'/plugin_sample2'])
            ->andReturn(
                json_decode(
                '{
                      "name": "xe/plugin_sample2",
                      "description": "xe ?????????????????????.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
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
                          "components": {
                            "module|board": {
                              "class": "XE\\\PluginA\\\Modules\\\Board",
                              "name": "?????????",
                              "description": "??????????????????."
                            },
                            "module|board|sortingType|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "????????? ??????????????????",
                              "description": "???????????? ?????? ?????????????????????."
                            },
                            "module|board|skin|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "????????? ????????????",
                              "description": "????????? ?????????????????????."
                            },
                            "module|xe_forum": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum",
                              "name": "??????",
                              "description": "???????????????."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "????????? ??????????????????",
                              "description": "????????? ???????????????????????????."
                            },
                            "uiobject|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "fieldType|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "widget|content|skin|sketchbookDefault": {
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
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );


        $reader->shouldReceive('read')
            ->withArgs(['/home/DOMAINS/LOCALHOST/xe/xe3-core/core/tests/Plugin/invalid_plugins/plugin_sample2'])
            ->andReturn(
                json_decode(
                '{
                      "name": "xe/plugin_sample2",
                      "description": "xe ?????????????????????.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
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
                          "components": {
                            "module|board": {
                              "class": "XE\\\PluginA\\\Modules\\\Board",
                              "name": "?????????",
                              "description": "??????????????????."
                            },
                            "module|board|sortingType|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "????????? ??????????????????",
                              "description": "???????????? ?????? ?????????????????????."
                            },
                            "module|board|skin|default": {
                              "class": "XE\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "????????? ????????????",
                              "description": "????????? ?????????????????????."
                            },
                            "module|xe_forum": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum",
                              "name": "??????",
                              "description": "???????????????."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "XE\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "????????? ??????????????????",
                              "description": "????????? ???????????????????????????."
                            },
                            "uiobject|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "fieldType|phone": {
                              "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "???????????? UI????????????",
                              "description": "??????????????? UI?????????????????????."
                            },
                            "widget|content|skin|sketchbookDefault": {
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
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );

        return $reader;
    }
}
