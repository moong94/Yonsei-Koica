<?php
/**
 * MediaHandler.php
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Models\Media;
use Xpressengine\Storage\File;

/**
 * Interface MediaHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface MediaHandler
{
    /**
     * 각 미디어 타입에서 사용가능한 확장자 인지 판별
     *
     * @param string $mime mime type
     * @return bool
     */
    public function isAvailable($mime);

    /**
     * 각 미디어 타입에서 사용가능한 확장자 반환
     *
     * @return array
     */
    public function getAvailableMimes();

    /**
     * media 객체로 반환
     *
     * @param File $file file instance
     * @return mixed
     */
    public function make(File $file);

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media media instance
     * @return string 이미지 content
     */
    public function getPicture(Media $media);

    /**
     * Make model
     *
     * @param File $file file instance
     * @return Media
     */
    public function makeModel(File $file);
}
