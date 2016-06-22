<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace cdcchen\wechat\qy\chat\push\models;


use cdcchen\wechat\base\Object;

/**
 * Class Base
 * @package cdcchen\wechat\qy\push\models
 */
abstract class Base extends Object
{
    /**
     * @var array
     */
    private $_data;

    /**
     * Base constructor.
     * @param $xml
     */
    public function __construct($xml)
    {
        $this->init();
        $this->parseXml($xml);
    }

    /**
     * init
     */
    protected function init()
    {
    }

    /**
     * @return string|null
     */
    public function getToUserName()
    {
        return $this->get('ToUserName');
    }

    /**
     * @return string|null
     */
    public function getFromUserName()
    {
        return $this->get('FromUserName');
    }

    /**
     * @return int|null
     */
    public function getCreateTime()
    {
        return $this->get('CreateTime');
    }

    /**
     * @return int|null
     */
    public function getAgentId()
    {
        return $this->get('AgentId');
    }

    /**
     * @return string|null
     */
    public function getMsgType()
    {
        return $this->get('MsgType');
    }

    /**
     * @param $name
     * @param null|mixed $defaultValue
     * @return null|mixed
     */
    protected function get($name, $defaultValue = null)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : $defaultValue;
    }

    /**
     * @param string $xml
     */
    private function parseXml($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xml === false) {
                throw new \BadFunctionCallException('Load xml error.');
            }
        }
        $this->_data = static::convertXmlElementToArray($xml);
    }

    /**
     * @param SimpleXMLElement
     * @return array
     */
    private static function convertXmlElementToArray($xml)
    {
        return json_decode(json_encode((array)$xml, 320), true);
    }
}