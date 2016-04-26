<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:31
 */

namespace cdcchen\wechat\qy\push\models;


class Voice extends Message
{
    public $mediaID;
    public $format;

    protected function parseSpecificXml()
    {
        $this->mediaID = (string)$this->_xml->MediaId;
        $this->format = (string)$this->_xml->Format;
    }

}