<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:22
 */

namespace cdcchen\wechat\qy\push\models;


class LocationSelectEvent extends Event
{
    public $eventKey;

    public $locationX;
    public $locationY;
    public $scale;
    public $label;
    public $poiName;

    protected function parseEventXml()
    {
        $this->eventKey = (string)$this->_xml->EventKey;

        $info = $this->_xml->SendLocationInfo;
        $this->locationX = (double)$info->Location_X;
        $this->locationY = (double)$info->Location_Y;
        $this->scale = (int)$info->Scale;
        $this->label = (string)$info->Label;
        $this->poiName = (string)$info->Poiname;

    }
}