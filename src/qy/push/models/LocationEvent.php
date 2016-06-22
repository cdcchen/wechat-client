<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:00
 */

namespace cdcchen\wechat\qy\push\models;


/**
 * Class LocationEvent
 * @package cdcchen\wechat\qy\push\models
 */
class LocationEvent extends EventMessage
{
    /**
     * @return double
     */
    public function getLatitude()
    {
        return (double)$this->get('Latitude');
    }

    /**
     * @return double
     */
    public function getLongitude()
    {
        return (double)$this->get('Longitude');
    }

    /**
     * @return float
     */
    public function getPrecision()
    {
        return (float)$this->get('Precision');
    }
}