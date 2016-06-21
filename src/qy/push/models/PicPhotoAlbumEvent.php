<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class PicPhotoAlbumEvent
 * @package cdcchen\wechat\qy\push\models
 */
class PicPhotoAlbumEvent extends Event
{
    use ParseSendPicsInfoTrait;

    /**
     * @return string
     */
    public function getEventKey()
    {
        return $this->getEventKey();
    }
}