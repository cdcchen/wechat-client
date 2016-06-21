<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:31
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Voice
 * @package cdcchen\wechat\qy\push\models
 */
class Voice extends Message
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
    public function getFormat()
    {
        return $this->get('Format');
    }

}