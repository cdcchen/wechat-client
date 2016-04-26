<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


class PicWeixinPhotoEvent extends Event
{
    use ParseSendPicsInfoTrait;

    public $eventKey;
    public $count;
    public $pics = [];

    protected function parseEventXml()
    {
        $this->eventKey = (string)$this->_xml->EventKey;

        $info = $this->_xml->SendPicsInfo;
        $this->count = (int)$info->Count;

        if ($this->count > 0)
            $this->pics = $this->parsePicInfo();
    }
}