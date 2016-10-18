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
class MessagePackage extends Object
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
     * @return string
     */
    public function getToUserName()
    {
        return $this->get('ToUserName');
    }

    /**
     * @return string
     */
    public function getCorpId()
    {
        return $this->getToUserName();
    }

    /**
     * @return string
     */
    public function getAgentType()
    {
        return $this->get('AgentType');
    }

    /**
     * @return int
     */
    public function getItemCount()
    {
        return (int)$this->get('ItemCount');
    }

    /**
     * @return string
     */
    public function getPackageId()
    {
        return $this->get('PackageId');
    }

    public function getItems()
    {
        static $_items = null;
        if ($_items !== null) {
            return $_items;
        }

        $items = $this->get('Item');
        if ($this->getItemCount() === 1) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $key = strtolower((string)$item['MsgType'] . (string)$item['Event']);
            $model = static::$modelMap[$key];

            if ($model) {
                $_items[] = new $model($item);
            } else {
                throw new \ErrorException('Unsupported msg type or event type.');
            }
        }

        return $_items;
    }

    /**
     * @var array
     */
    static protected $modelMap = [
        BaseItem::MSG_TYPE_TEXT => 'cdcchen\wechat\qy\chat\push\models\TextMessage',
        BaseItem::MSG_TYPE_IMAGE => 'cdcchen\wechat\qy\chat\push\models\ImageMessage',
        BaseItem::MSG_TYPE_VOICE => 'cdcchen\wechat\qy\chat\push\models\VoiceMessage',
        BaseItem::MSG_TYPE_FILE => 'cdcchen\wechat\qy\chat\push\models\FileMessage',
        BaseItem::MSG_TYPE_LINK => 'cdcchen\wechat\qy\chat\push\models\LinkMessage',

        BaseItem::MSG_TYPE_EVENT . BaseItem::EVENT_CREATE_CHAT => 'cdcchen\wechat\qy\chat\push\models\CreateChatEvent',
        BaseItem::MSG_TYPE_EVENT . BaseItem::EVENT_UPDATE_CHAT => 'cdcchen\wechat\qy\chat\push\models\UpdateChatEvent',
        BaseItem::MSG_TYPE_EVENT . BaseItem::EVENT_QUIT_CHAT => 'cdcchen\wechat\qy\chat\push\models\QuitChatEvent',
        BaseItem::MSG_TYPE_EVENT . BaseItem::EVENT_SUBSCRIBE => 'cdcchen\wechat\qy\chat\push\models\SubscribeEvent',
        BaseItem::MSG_TYPE_EVENT . BaseItem::EVENT_UNSUBSCRIBE => 'cdcchen\wechat\qy\chat\push\models\UnSubscribeEvent',
    ];

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