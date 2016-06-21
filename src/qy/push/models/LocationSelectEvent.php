<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:22
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class LocationSelectEvent
 * @package cdcchen\wechat\qy\push\models
 */
class LocationSelectEvent extends Event
{
    /**
     * @return string
     */
    public function getEventKey()
    {
        return $this->get('EventKey');
    }

    /**
     * @return float
     */
    public function getX()
    {
        return (double)$this->getSendLocationInfo('Location_X');
    }

    /**
     * @return float
     */
    public function getY()
    {
        return (double)$this->getSendLocationInfo('Location_Y');
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return (int)$this->getSendLocationInfo('Scale');
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->getSendLocationInfo('Label');
    }

    /**
     * @return string
     */
    public function getPoiName()
    {
        return $this->getSendLocationInfo('poiName');
    }

    /**
     * @param $name
     * @return null|mixed
     */
    private function getSendLocationInfo($name)
    {
        $info = $this->get('SendLocationInfo');
        return isset($info[$name]) ? $info[$name] : null;
    }
}