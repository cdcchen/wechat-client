<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 13:15
 */

namespace cdcchen\wechat\qy\material;


use cdcchen\wechat\base\BaseRequest;
use cdcchen\wechat\qy\base\Media;

/**
 * Class MaterialUploadRequest
 * @package cdcchen\wechat\qy\material
 */
class MaterialUploadRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/add_material';

    /**
     * @param string $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setQueryParam('type', $value);
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function setMedia(Media $media)
    {
        return $this->setData('media', $media->getFormData())
                    ->addFile('upload_file', $media->getUploadFile());
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['type', 'media'];
    }
}