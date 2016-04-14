<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午2:24
 */

namespace weixin\qy\push\models;


class ScanCodePushEvent extends Event
{
    public $eventKey;
    public $scanType;
    public $scanResult;

    protected function parseEventXml()
    {
        $this->eventKey = (string)$this->_xml->EventKey;
        $this->scanType = (string)$this->_xml->ScanCodeInfo->ScanType;
        $this->scanResult = (string)$this->_xml->ScanCodeInfo->ScanResult;
    }
}
