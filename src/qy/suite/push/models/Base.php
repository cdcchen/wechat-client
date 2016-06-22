<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午1:22
 */

namespace cdcchen\wechat\qy\suite\push\models;


use cdcchen\wechat\base\Object;

/**
 * Class Base
 * @package cdcchen\wechat\qy\push\models
 */
abstract class Base extends Object
{
    const TYPE_SEND_TICKET = 'suite_ticket';
    const TYPE_CHANGE_AUTH = 'change_auth';
    const TYPE_CANCEL_AUTH = 'cancel_auth';
    const TYPE_CREATE_AUTH = 'create_auth';

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
    public function getSuiteId()
    {
        return $this->get('SuiteId');
    }

    /**
     * @return string|null
     */
    public function getInfoType()
    {
        return $this->get('InfoType');
    }

    /**
     * @return int|null
     */
    public function getTimeStamp()
    {
        return $this->get('TimeStamp');
    }

    /**
     * @return bool
     */
    public function isSendTicket()
    {
        return $this->getInfoType() === self::TYPE_SEND_TICKET;
    }

    /**
     * @return bool
     */
    public function isChangeAuth()
    {
        return $this->getInfoType() === self::TYPE_CHANGE_AUTH;
    }

    /**
     * @return bool
     */
    public function isCancelAuth()
    {
        return $this->getInfoType() === self::TYPE_CANCEL_AUTH;
    }

    /**
     * @return bool
     */
    public function isCreateAuth()
    {
        return $this->getInfoType() === self::TYPE_CREATE_AUTH;
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