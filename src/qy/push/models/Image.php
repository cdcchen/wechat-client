<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:30
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Image
 * @package cdcchen\wechat\qy\push\models
 */
class Image extends Message
{
    /**
     * @return string
     */
    public function getMediaId()
    {
        return $this->get('MediaId');
    }

    /**
     * @return string
     */
    public function getPicUrl()
    {
        return $this->get('PicUrl');
    }
}