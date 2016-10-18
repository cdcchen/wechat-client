<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/22
 * Time: 19:09
 */

namespace cdcchen\wechat\qy\chat\push\models;


/**
 * Class LocationMessage
 * @package cdcchen\wechat\qy\chat\push\models
 */
class LocationMessage extends Message
{
    /**
     * @return float
     */
    public function getLocationX()
    {
        return $this->get('Location_X');
    }

    /**
     * @return float
     */
    public function getLocationY()
    {
        return $this->get('Location_Y');
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return $this->get('Scale');
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->get('Label');
    }
}