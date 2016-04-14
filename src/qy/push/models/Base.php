<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace weixin\qy\push\models;


abstract class Base
{
    public $toUserName;
    public $fromUserName;
    public $createTime;
    public $agentID;
    public $msgType;

    protected $_xml;

    public function __construct($xml)
    {
        $this->init();
        $this->parseBaseXml($xml);
        $this->parseExtraXml();
    }

    protected function parseBaseXml($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xml === false)
                throw new \BadFunctionCallException('Load xml error.');
        }

        $this->_xml = $xml;

        $this->toUserName = (string)$xml->ToUserName;
        $this->fromUserName = (string)$xml->FromUserName;
        $this->createTime = (int)$xml->CreateTime;
        $this->msgType = (string)$xml->MsgType;
        $this->agentID = (int)$xml->AgentID;
    }

    protected function init()
    {
    }

    abstract protected function parseExtraXml();
}