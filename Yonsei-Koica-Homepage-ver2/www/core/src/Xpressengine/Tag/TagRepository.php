<?php
/**
 * TagRepository.php
 *
 * PHP version 7
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\QueryException;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * TagRepository.php
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagRepository
{
    use EloquentRepositoryTrait;

    /**
     * Attach tag to taggable
     *
     * @param string $taggableId taggable id
     * @param Tag[]  $tags       tag instances
     * @return void
     */
    public function attach($taggableId, $tags)
    {
        $conn = $this->createModel()->getConnection();
        $position = 0;
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            try {
                // 대상아이디와 태그 아이템 아이디가 unique 키로 설정되어
                // 존재 유무와 상관없이 insert 시도 함
                // duplicate error 무시
                $conn->table($tag->getTaggableTable())->insert([
                    'tag_id' => $tag->getKey(),
                    'taggable_id' => $taggableId,
                    'position' => $position,
                    'created_at' => $this->getNow()
                ]);

                $tag->increment('count');
            } catch (QueryException $e) {
                if ($e->getCode() != "23000") {
                    throw $e;
                }

                $conn->table($tag->getTaggableTable())
                    ->where('tag_id', $tag->getKey())
                    ->where('taggable_id', $taggableId)
                    ->update(['position' => $position]);
            }

            $position++;
        }
    }

    /**
     * Detach tag to taggable
     *
     * @param string $taggableId taggable id
     * @param Tag[]  $tags       tag instances
     * @return void
     * @throws \Exception
     */
    public function detach($taggableId, $tags)
    {
        $conn = $this->createModel()->getConnection();
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $conn->table($tag->getTaggableTable())
                ->where('tag_id', $tag->getKey())
                ->where('taggable_id', $taggableId)
                ->delete();

            $tag->decrement('count');

            if ($tag->count <= 0) {
                $tag->delete();
            }
        }
    }

    /**
     * Returns tags of the taggable
     *
     * @param string $taggableId taggable id
     * @return Collection|Tag[]
     */
    public function fetchByTaggable($taggableId)
    {
        $model = $this->createModel();

        return $this->query()
            ->rightJoin($model->getTaggableTable(), $model->getTable().'.id', '=', $model->getTaggableTable().'.tag_id')
            ->where('taggable_id', $taggableId)
            ->orderBy('position')
            ->select([$model->getTable().'.*'])
            ->get();
    }

    /**
     * Returns taggables of the tag
     *
     * @param string $tagId tagId
     * @return \Illuminate\Support\Collection
     */
    public function fetchByTag($tagId)
    {
        $model = $this->createModel();
        $conn = $model->getConnection();

        return $conn->table($model->getTaggableTable())
            ->where('tag_id', $tagId)
            ->get();
    }

    /**
     * Returns most popular tags
     *
     * @param string|null $instanceId instance id
     * @param int         $take       take count
     * @return Collection|Tag[]
     */
    public function fetchPopular($instanceId = null, $take = 15)
    {
        $query = $this->query()->orderBy('count', 'desc')->orderBy('id', 'desc')->take($take);

        if ($instanceId !== null) {
            $query->where('instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns most popular tags in whole
     *
     * @param int $take take count
     * @return Collection|Tag[]
     */
    public function fetPopularWhole($take = 15)
    {
        return $this->fetchPopular(null, $take);
    }

    /**
     * Returns most popular tags of date period
     *
     * @param \DateTime|string      $since      begin date
     * @param \DateTime|string|null $until      end date
     * @param string|null           $instanceId instance id
     * @param int                   $take       take count
     * @return Collection|Tag[]
     */
    public function fetchPopularPeriod($since, $until = null, $instanceId = null, $take = 15)
    {
        $model = $this->createModel();

        $query = $this->query()
            ->rightJoin($model->getTaggableTable(), $model->getTaggableTable().'.tag_id', '=', $model->getTable().'.id')
            ->select([$model->getTable().'.*', new Expression('count(*) as cnt')])
            ->groupBy($model->getTable().'.word')
            ->orderBy('cnt', 'desc')
            ->orderBy('id', 'desc')
            ->take($take);

        if ($until !== null) {
            $query->whereBetween($this->getTaggableTable().'.created_at', [$since, $until]);
        } else {
            $query->where($this->getTaggableTable().'.created_at', '>', $since);
        }

        if ($instanceId !== null) {
            $query->where($model->getTable().'.instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns most popular tags of date period in whole
     *
     * @param \DateTime|string      $since begin date
     * @param \DateTime|string|null $until end date
     * @param int                   $take  take count
     * @return Collection|Tag[]
     */
    public function fetchPopularPeriodWhole($since, $until = null, $take = 15)
    {
        return $this->fetchPopularPeriod($since, $until, null, $take);
    }

    /**
     * Search similar tags by given string
     *
     * @param string      $decomposed decomposed word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return Collection|Tag[]
     */
    public function fetchSimilar($decomposed, $take = 15, $instanceId = null)
    {
        $query = $this->query()
            ->where('decomposed', 'like', $decomposed . '%')
            ->orderBy('count', 'desc')
            ->take($take);

        if ($instanceId) {
            $query->where('instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns Datetime instance for now
     *
     * @return \DateTime|Carbon
     */
    protected function getNow()
    {
        return Carbon::now();
    }
}
