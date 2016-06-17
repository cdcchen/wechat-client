<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 15:26
 */

namespace cdcchen\wechat\qy\material;


/**
 * Class UpdateMPNewsRequest
 * @package cdcchen\wechat\qy\material
 */
class UpdateMPNewsRequest extends UploadMPNewsRequest
{
    /**
     * @var string
     */
    protected $action = '/cgi-bin/material/update_mpnews';

    /**
     * @param string $id
     * @return $this
     */
    public function setMediaId($id)
    {
        return $this->setData('media_id', $id);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        $params = parent::getRequireParams();
        $params[] = 'media_id';
        return $params;
    }
}