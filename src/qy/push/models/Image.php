<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:30
 */

namespace weixin\qy\push\models;


class Image extends Message
{
    public $picUrl;
    public $mediaID;

    protected function parseSpecificXml()
    {
        $this->picUrl = (string)$this->_xml->PicUrl;
        $this->mediaID = (string)$this->_xml->MediaId;
    }
}