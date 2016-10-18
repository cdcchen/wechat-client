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
abstract class BaseItem extends Object
{
    const EVENT_CREATE_CHAT = 'create_chat';
    const EVENT_UPDATE_CHAT = 'update_chat';
    const EVENT_QUIT_CHAT   = 'quit_chat';
    const EVENT_SUBSCRIBE   = 'subscribe';
    const EVENT_UNSUBSCRIBE = 'unsubscribe';

    const MSG_TYPE_EVENT = 'event';
    const MSG_TYPE_TEXT  = 'text';
    const MSG_TYPE_IMAGE = 'image';
    const MSG_TYPE_FILE  = 'file';
    const MSG_TYPE_VOICE = 'voice';
    const MSG_TYPE_LINK  = 'link';

    /**
     * @var array
     */
    private $_data;

    /**
     * Base constructor.
     * @param array|string $data
     */
    public function __construct($data)
    {
        $this->init();
        if (is_array($data)) {
            $this->_data = $data;
        } elseif (is_string($data)) {
            $this->parseXml($data);
        } else {
            throw new \InvalidArgumentException('$data type is invalid.');
        }
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
     * @return string|null
     */
    public function getMsgType()
    {
        return $this->get('MsgType');
    }


    /**
     * @return bool
     */
    public function IsEventMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_EVENT;
    }

    /**
     * @return bool
     */
    public function IsTextMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_TEXT;
    }

    /**
     * @return bool
     */
    public function IsImageMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_IMAGE;
    }

    /**
     * @return bool
     */
    public function IsFileMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_FILE;
    }

    /**
     * @return bool
     */
    public function IsVoiceMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_VOICE;
    }

    /**
     * @return bool
     */
    public function IsLinkMessage()
    {
        return $this->getMsgType() === self::MSG_TYPE_LINK;
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