<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:12
 */

namespace cdcchen\wechat\qy\push;


use cdcchen\wechat\base\Object;
use cdcchen\wechat\qy\push\models\Base;
use cdcchen\wechat\qy\push\models\EventMessage;
use cdcchen\wechat\qy\push\models\Message;
use cdcchen\wechat\security\PrpCrypt;

/**
 * Class MessageRequest
 * @package cdcchen\wechat\qy\push
 */
class MessageRequest extends Object
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
            throw new \ErrorException("Unsupported msg type or event type. Key: $key, Model: $model");
        }
    }


    /**
     * @var array
     */
    static protected $modelMap = [
        Message::TYPE_TEXT => 'cdcchen\wechat\qy\push\models\TextMessage',
        Message::TYPE_IMAGE => 'cdcchen\wechat\qy\push\models\ImageMessage',
        Message::TYPE_VOICE => 'cdcchen\wechat\qy\push\models\VoiceMessage',
        Message::TYPE_VIDEO => 'cdcchen\wechat\qy\push\models\VideoMessage',
        Message::TYPE_SHORT_VIDEO => 'cdcchen\wechat\qy\push\models\ShortVideoMessage',
        Message::TYPE_LOCATION => 'cdcchen\wechat\qy\push\models\LocationMessage',
        Message::TYPE_LINK => 'cdcchen\wechat\qy\push\models\LinkMessage',

        Message::TYPE_EVENT . EventMessage::EVENT_SUBSCRIBE => 'cdcchen\wechat\qy\push\models\EventMessage',
        Message::TYPE_EVENT . EventMessage::EVENT_UNSUBSCRIBE => 'cdcchen\wechat\qy\push\models\EventMessage',
        Message::TYPE_EVENT . EventMessage::EVENT_LOCATION => 'cdcchen\wechat\qy\push\models\LocationEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_CLICK => 'cdcchen\wechat\qy\push\models\ClickEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_VIEW => 'cdcchen\wechat\qy\push\models\ViewEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_SCANCODE_PUSH => 'cdcchen\wechat\qy\push\models\ScanCodePushEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_SCANCODE_WAITMSG => 'cdcchen\wechat\qy\push\models\ScanCodeWaitMsgEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_PIC_SYSPHOTO => 'cdcchen\wechat\qy\push\models\PicPhotoEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_PIC_PHOTO_OR_ALBUM => 'cdcchen\wechat\qy\push\models\PicPhotoAlbumEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_PIC_WEIXIN_PHOTO => 'cdcchen\wechat\qy\push\models\PicWeixinPhotoEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_LOCATION_SELECT => 'cdcchen\wechat\qy\push\models\LocationSelectEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_ENTER_AGENT => 'cdcchen\wechat\qy\push\models\EnterAgentEvent',
        Message::TYPE_EVENT . EventMessage::EVENT_BATCH_JOB_RESULT => 'cdcchen\wechat\qy\push\models\BatchJobEvent',
    ];
}