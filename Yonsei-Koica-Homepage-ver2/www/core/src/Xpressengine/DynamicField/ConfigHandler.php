<?php
/**
 * ConfigHandler
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\VirtualConnectionInterface;

/**
 * ConfigHandler
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigHandler
{
    const CONFIG_NAME = 'dynamicField';
    const CREATE_TABLE_METHOD = false;
    const ALTER_TABLE_METHOD = true;
    const DEFAULT_JOIN_COLUMN_NAME = 'id';

    /**
     * @var string
     */
    protected $tablePrefix = 'field';

    /**
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * default config
     *
     * @var array
     */
    protected $default = [
        'group' => null,
        'id' => null,
        'label' => null,
        'labelDescription' => null,
        'typeId' => null,
        'typeName' => null,
        'skinId' => null,
        'skinName' => null,
        'joinColumnName' => null,
        'required' => false,
        'sortable' => false,
        'searchable' => false,
        'use' => true,
        'revision' => false,
        'tableMethod' => self::CREATE_TABLE_METHOD,
    ];

    /**
     * create instance
     *
     * @param VirtualConnectionInterface $connection    database connection
     * @param ConfigManager              $configManager config manager
     */
    public function __construct(VirtualConnectionInterface $connection, ConfigManager $configManager)
    {
        $this->connection = $connection;
        $this->configManager = $configManager;
    }

    /**
     * get default config
     *
     * @return ConfigEntity
     */
    public function getDefault()
    {
        $config = $this->configManager->get(self::CONFIG_NAME);
        if ($config === null) {
            $config = new ConfigEntity($this->default);
        }
        return $config;
    }

    /**
     * config ??????
     *
     * @param ConfigEntity $config config entity
     * @return void
     */
    public function add(ConfigEntity $config)
    {
        $this->configManager->add($this->getConfigName($config), $config->getPureAll());
    }

    /**
     * config ??????
     *
     * @param ConfigEntity $config config entity
     * @return void
     */
    public function put(ConfigEntity $config)
    {
        $this->configManager->put($this->getConfigName($config), $config->getPureAll());
    }

    /**
     * config ??????
     *
     * @param ConfigEntity $config config entity
     * @return void
     */
    public function remove(ConfigEntity $config)
    {
        $this->configManager->remove($config);
    }

    /**
     * config entity ??????
     *
     * @param string $group group name
     * @param string $id    dynamic field id
     * @return ConfigEntity|null
     */
    public function get($group, $id)
    {
        return $this->configManager->get(sprintf('%s.%s.%s', self::CONFIG_NAME, $group, $id));
    }

    /**
     * config entity list ??????
     *
     * @param string $group group name
     * @return array
     */
    public function gets($group)
    {
        $config = $this->parent($group);
        if ($config === null) {
            return [];
        }
        return $this->configManager->children($config);
    }

    /**
     * group ??? parent config ??????
     * config entity ??????
     *
     * @param string $group group name
     * @return ConfigEntity|null
     */
    public function parent($group)
    {
        return $this->configManager->get(
            sprintf('%s.%s', self::CONFIG_NAME, $group)
        );
    }

    /**
     * parent config ??????
     *
     * @param string $group group name
     * @return void
     * @throws \Xpressengine\Config\Exceptions\InvalidArgumentException
     */
    public function setParent($group)
    {
        $this->configManager->add(sprintf('%s.%s', self::CONFIG_NAME, $group), []);
    }

    /**
     * set table prefix
     *
     * @param string $tablePrefix table prefix
     * @return void
     */
    public function setTablePrefix($tablePrefix)
    {
        $this->tablePrefix = $tablePrefix;
    }

    /**
     * ConfigEntity ?????? ConfigManager ??? ????????? config ?????? ??????.
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getConfigName(ConfigEntity $config)
    {
        if ($config->get('id') === null) {
            return sprintf(
                '%s.%s',
                self::CONFIG_NAME,
                $config->get('group')
            );
        } else {
            return sprintf(
                '%s.%s.%s',
                self::CONFIG_NAME,
                $config->get('group'),
                $config->get('id')
            );
        }
    }

    /**
     * $config ??? group ??? id ??? ???????????? field type ??? database table ?????? ??????
     * dynamic field type ??? ????????? ?????? table ??????
     *
     * @param ConfigEntity $config config entity
     * @return string
     *
     * @deprecated since version 3.0.1 instead use $type->getTableName()
     */
    public function getTableName(ConfigEntity $config)
    {
        return sprintf(
            '%s_%s_%s',
            $this->tablePrefix,
            $config->get('group'),
            $config->get('id')
        );
    }

    /**
     * ????????? database table ??? revision table ?????? ??????.
     *
     * @param ConfigEntity $config config entity
     * @return string
     *
     * @deprecated since version 3.0.1 instead use $type->getRevisionTableName()
     */
    public function getRevisionTableName(ConfigEntity $config)
    {
        return sprintf(
            '%s_revision_%s_%s',
            $this->tablePrefix,
            $config->get('group'),
            $config->get('id')
        );
    }

    /**
     * ????????? Dynamic Field ??? ????????? ?????? ???????????? ??????
     *
     * @param ConfigEntity $config config entity
     * @return bool
     */
    public function isTableMethodCreate(ConfigEntity $config)
    {
        return $config->get('tableMethod') === self::CREATE_TABLE_METHOD;
    }

    /**
     * get validator rules
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
