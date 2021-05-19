<?php
/**
 * This file is Audio model class
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

namespace Xpressengine\Media\Models;

use Xpressengine\Media\Models\Meta\AudioMeta;

/**
 * audio 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @property int $id
 * @property string $fileId
 * @property array $audio
 * @property int $playtime
 * @property int $bitrate
 */
class Audio extends Media
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'audio' => 'array',
    ];

    /**
     * Available mime type
     *
     * @var array
     */
    protected static $mimes = ['audio/mpeg', 'audio/ogg', 'audio/wav'];

    /**
     * Returns meta data model for current model
     *
     * @return string
     */
    public function getMetaModel()
    {
        return AudioMeta::class;
    }

    /**
     * Rendered media
     *
     * @param array $option rendering option
     * @return string
     */
    public function render(array $option = [])
    {
        return '<audio controls src="' . $this->url() . '">' .
            'Your user agent does not support the HTML5 Audio element.' .
            '</audio>';
    }

    /**
     * Returns media type
     *
     * @return string
     */
    public function getType()
    {
        return Media::TYPE_AUDIO;
    }
}
