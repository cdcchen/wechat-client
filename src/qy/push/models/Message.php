<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace cdcchen\wechat\qy\push\models;


class Message extends Base
{
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_SHORT_VIDEO = 'shortvideo';
    const TYPE_LOCATION = 'location';
    const TYPE_EVENT = 'event';

    public $msgID;

    protected function parseExtraXml()
    {
        $this->msgID = (string)$this->_xml->MsgId;

        $this->parseSpecificXml();
    }

    protected function parseSpecificXml()
    {
    }
}