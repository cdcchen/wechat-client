<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:37
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class Location
 * @package cdcchen\wechat\qy\push\models
 */
class Location extends Message
{
    /**
     * @return float
     */
    public function getX()
    {
        return (double)$this->get('Location_X');
    }

    /**
     * @return float
     */
    public function getY()
    {
        return (double)$this->get('Location_Y');
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return (int)$this->get('Scale');
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->get('Label');
    }
}