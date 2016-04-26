<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:37
 */

namespace cdcchen\wechat\qy\push\models;


class Location extends Message
{
    public $locationX;
    public $locationY;
    public $scale;
    public $label;

    protected function parseSpecificXml()
    {
        $this->locationX = (double)$this->_xml->Location_X;
        $this->locationY = (double)$this->_xml->Location_Y;
        $this->scale = (int)$this->_xml->Scale;
        $this->label = (string)$this->_xml->Label;
    }
}