<?php
/**
 * DynamicFieldSection.php
 *
 * PHP version 7
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use XeFrontend;
use View;
use Xpressengine\Database\VirtualConnectionInterface;
use XeConfig;
use Xpressengine\Config\ConfigEntity;

/**
 * Class DynamicFieldSection
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldSection extends Section
{
    const CACHE_SESSION_NAME = 'DF_CACHE';
    const STEP_SESSION_NAME = 'DF_STEP';
    const UPDATE_FLAG_SESSION_NAME = 'DF_UPDATE_FLAG';

    /**
     * @var string
     */
    protected $group;

    /**
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @var bool
     */
    protected $revision;

    /**
     * create instance
     *
     * @param string                     $group    config group name
     * @param VirtualConnectionInterface $conn     database connection
     * @param bool                       $revision 리비전 처리
     */
    public function __construct($group, VirtualConnectionInterface $conn, $revision = false)
    {
        $this->group = $group;
        $this->conn = $conn;
        $this->revision = $revision;
    }

    /**
     * form create validation rules
     *
     * @return array
     */
    public static function getCreateRules()
    {
        return [
            'typeId' => 'Required',
            'id' => 'Required|df_id|Between:2,20',
            'label' => 'LangRequired',
            'skinId' => 'Required',
        ];
    }

    /**
     * form update validation rules
     *
     * @return array
     */
    public static function getUpdateRules()
    {
        return [
            'typeId' => 'Required',
            'id' => 'Required|df_id|Between:2,20',
        ];
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        /** @var \Xpressengine\DynamicField\DynamicFieldHandler $dynamicField */
        $dynamicField = app('xe.dynamicField');
        $parent = $dynamicField->getConfigHandler()->parent($this->group);

        $configs = [];
        if ($parent !== null) {
            /**
             * @var ConfigEntity $config
             */
            foreach (XeConfig::children($parent) as $config) {
                if ($config->get('use') === true) {
                    $configs[$config->get('id')] = $config;
                }
            }
        }

        /**
         * @var \Xpressengine\DynamicField\RegisterHandler $registerHandler
         */
        $dynamicFieldHandler = app('xe.dynamicField');
        $registerHandler = $dynamicFieldHandler->getRegisterHandler();
        $types = $registerHandler->getTypes($dynamicFieldHandler);
        $fieldTypes = [];
        foreach ($types as $types) {
            $fieldTypes[] = $types;
        }

        XeFrontend::rule('dynamicFieldSection', static::getCreateRules());
        XeFrontend::translation(['xe::validation.df_id']);

        // 다국어 입력 필드
        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.min.css')->load();
        XeFrontend::js('/assets/core/lang/langEditorBox.bundle.js')->appendTo('head')->load();
        XeFrontend::css('/assets/core/lang/langEditorBox.css')->load();
        XeFrontend::css('/assets/core/xe-ui-component/xe-ui-component.css')->load();

        return View::make('dynamicField.setting', [
            'databaseName' => $this->conn->getName(),
            'group' => $this->group,
            'configs' => $configs,
            'fieldTypes' => $fieldTypes,
            'revision' => $this->revision,
        ]);
    }
}
