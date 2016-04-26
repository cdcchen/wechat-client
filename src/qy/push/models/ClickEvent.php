<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace cdcchen\wechat\qy\push\models;


class ClickEvent extends Event
{
    public $eventKey;

    protected function parseEventXml()
    {
        $this->eventKey = (string)$this->_xml->EventKey;
    }
}