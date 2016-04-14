<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:31
 */

namespace weixin\qy\push\models;


class ShortVideo extends Message
{
    public $mediaID;
    public $thumbMediaID;

    protected function parseSpecificXml()
    {
        $this->mediaID = (string)$this->_xml->MediaId;
        $this->thumbMediaID = (string)$this->_xml->ThumbMediaId;
    }
}