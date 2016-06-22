<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 19:09
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class ImageMessage
 * @package cdcchen\wechat\qy\chat\push\models
 */
class ImageMessage extends MediaMessage
{
    /**
     * @return string
     */
    public function getPicUrl()
    {
        return $this->get('PicUrl');
    }
}