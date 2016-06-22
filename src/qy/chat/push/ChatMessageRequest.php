<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:12
 */

namespace cdcchen\wechat\qy\push;


use cdcchen\wechat\base\Object;
use cdcchen\wechat\qy\chat\push\models\Base;
use cdcchen\wechat\qy\chat\push\models\BaseItem;
use cdcchen\wechat\security\PrpCrypt;

/**
 * Class ChatMessageRequest
 * @package cdcchen\wechat\qy\chat\push
 */
class ChatMessageRequest extends Object
{
    /**
     * @var string
     */
    private $_token;
    /**
     * @var string
     */
    private $_encodingAesKey;
    /**
     * @var string
     */
    private $_corpId;

    /**
     * Request constructor.
     * @param string $corpId
     * @param string $token
     * @param string $encodingAesKey
     */
    public function __construct($corpId, $token, $encodingAesKey)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;
        $this->_corpId = $corpId;
    }

    /**
     * @param string $body
     * @return mixed
     * @throws \ErrorException
     */
    public function buildMessage($body)
    {
        $decrypt = $this->decrypt($body);

        return static::createModel($decrypt);
    }

    /**
     * @param $body
     * @return \SimpleXMLElement
     */
    public static function buildXmlElement($body)
    {
        return simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    /**
     * @param string $body
     * @return string
     */
    protected function decrypt($body)
    {
        $xml = static::buildXmlElement($body);

        $crypt = new PrpCrypt($this->_encodingAesKey);
        return $crypt->decrypt((string)$xml->Encrypt, $this->_corpId);
    }

    /**
     * @param string $decrypt
     * @return Base
     * @throws \ErrorException
     */
    protected static function createModel($decrypt)
    {
        $xml = simplexml_load_string($decrypt, 'SimpleXMLElement', LIBXML_NOCDATA);

        $msgType = (string)$xml->MsgType;
        $eventType = (string)$xml->Event;

        $key = strtolower($msgType . $eventType);
        $model = static::$modelMap[$key];

        if ($model) {
            return new $model($xml);
        } else {
            throw new \ErrorException('Unsupported msg type or event type.');
        }
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
}