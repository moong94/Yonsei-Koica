<?php
/**
 * CounterLog
 *
 * PHP version 7
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Counter\Models;

use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * CounterLog
 *
 * @property string id
 * @property string counter_name
 * @property string counter_option
 * @property string target_id
 * @property string user_id
 * @property integer point
 * @property string ipaddress
 * @property string created_at
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CounterLog extends DynamicModel
{
    /**
     * @var string
     */
    protected $table = 'counter_log';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * User relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Xpressengine\User\Models\User', 'id', 'user_id');
    }
}
