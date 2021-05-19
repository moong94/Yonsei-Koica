<?php
/**
 * This file is category item model class.
 *
 * PHP version 7
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xpressengine\Support\Tree\Node;

/**
 * Class CategoryItem
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CategoryItem extends Node
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_item';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The pivot table associated with the model.
     *
     * @var string
     */
    protected $closureTable = 'category_closure';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'parent_id', 'word', 'description', 'ordering'];

    /**
     * The class name of aggregator
     *
     * @var string
     */
    protected static $aggregator;

    /**
     * Alias aggregator
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->aggregator();
    }

    /**
     * Get a children collection of model
     *
     * @return Collection
     */
    public function getChildren()
    {
        if (!$this->children) {
            $this->children = $this->where($this->getParentIdName(), $this->getKey())
                ->get()
                ->sort(function (Node $a, Node $b) {
                    $aOrdering = $a->{$a->getOrderKeyName()};
                    $bOrdering = $b->{$b->getOrderKeyName()};

                    if ($aOrdering == $bOrdering) {
                        return 0;
                    }

                    return $aOrdering < $bOrdering ? -1 : 1;
                });
        }

        return $this->children;
    }

    /**
     * Get the pivot table for model's hierarchy
     *
     * @return string
     */
    public function getClosureTable()
    {
        return $this->closureTable;
    }

    /**
     * Get the ancestor key name of pivot table
     *
     * @return string
     */
    public function getAncestorName()
    {
        return 'ancestor';
    }

    /**
     * Get the descendant key name of pivot table
     *
     * @return string
     */
    public function getDescendantName()
    {
        return 'descendant';
    }

    /**
     * Get the depth key name of pivot table
     *
     * @return string
     */
    public function getDepthName()
    {
        return 'depth';
    }

    /**
     * Get the parent key name for model
     *
     * @return string
     */
    public function getParentIdName()
    {
        return 'parent_id';
    }

    /**
     * Get the order key name for model
     *
     * @return string
     */
    public function getOrderKeyName()
    {
        return 'ordering';
    }

    /**
     * Get the aggregator model name for model
     *
     * @return string
     */
    public function getAggregatorModel()
    {
        return static::$aggregator;
    }

    /**
     * Get the aggregator key name for model
     *
     * @return string
     */
    public function getAggregatorKeyName()
    {
        return 'category_id';
    }

    /**
     * Set the aggregator model name for model
     *
     * @param string $model model name
     * @return void
     */
    public static function setAggregatorModel($model)
    {
        static::$aggregator = '\\' . ltrim($model, '\\');
    }
}
