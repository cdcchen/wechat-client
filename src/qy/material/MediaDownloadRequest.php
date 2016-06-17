<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 14:39
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class MediaDownloadRequest
 * @package cdcchen\wechat\qy\material
 */
class MediaDownloadRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'get';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/media/get';

    /**
     * @param string $value
     * @return $this
     */
    public function setMediaId($value)
    {
        return $this->setQueryParam('media_id', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['media_id'];
    }
}