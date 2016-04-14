<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:00
 */

namespace weixin\qy\push\models;


class LocationEvent extends Event
{
    public $latitude;
    public $longitude;
    public $precision;

    protected function parseEventXml()
    {
        $this->latitude = (double)$this->_xml->Latitude;
        $this->longitude = (double)$this->_xml->Longitude;
        $this->precision = (double)$this->_xml->Precision;
    }
}