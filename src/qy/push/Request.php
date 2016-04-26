<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:12
 */

namespace cdcchen\wechat\qy\push;


use cdcchen\wechat\qy\push\models\Event;
use cdcchen\wechat\qy\push\models\Message;
use cdcchen\wechat\security\PrpCrypt;

class Request
{
    private $_token;
    private $_encodingAesKey;
    private $_corpID;

    public function __construct($corp_id, $token, $encoding_aes_key)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encoding_aes_key;
        $this->_corpID = $corp_id;
    }

    public function buildMessage($body)
    {
        $decrypt = $this->decrypt($body);

        return static::createModel($decrypt);
    }

    protected function decrypt($body)
    {
        $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);

        $crypt = new PrpCrypt($this->_encodingAesKey);
        return $crypt->decrypt((string)$xml->Encrypt, $this->_corpID);
    }

    protected static function createModel($decrypt)
    {
        $xml = simplexml_load_string($decrypt, 'SimpleXMLElement', LIBXML_NOCDATA);

        $msgType = (string)$xml->MsgType;
        $eventType = (string)$xml->Event;

        $key = strtolower($msgType . $eventType);
        $model = static::$modelMap[$key];

        if ($model) {
            return new $model($xml);
        }
        else
            throw new \ErrorException('Unsupported msg type or event type.');
    }



    static protected $modelMap = [
        Message::TYPE_TEXT => 'cdcchen\wechat\qy\push\models\Text',
        Message::TYPE_IMAGE => 'cdcchen\wechat\qy\push\models\Image',
        Message::TYPE_VOICE => 'cdcchen\wechat\qy\push\models\Voice',
        Message::TYPE_VIDEO => 'cdcchen\wechat\qy\push\models\Video',
        Message::TYPE_SHORT_VIDEO => 'cdcchen\wechat\qy\push\models\ShortVideo',
        Message::TYPE_LOCATION => 'cdcchen\wechat\qy\push\models\Location',

        Message::TYPE_EVENT . Event::EVENT_SUBSCRIBE => 'cdcchen\wechat\qy\push\models\Event',
        Message::TYPE_EVENT . Event::EVENT_UNSUBSCRIBE => 'cdcchen\wechat\qy\push\models\Event',
        Message::TYPE_EVENT . Event::EVENT_LOCATION => 'cdcchen\wechat\qy\push\models\LocationEvent',
        Message::TYPE_EVENT . Event::EVENT_CLICK => 'cdcchen\wechat\qy\push\models\ClickEvent',
        Message::TYPE_EVENT . Event::EVENT_VIEW => 'cdcchen\wechat\qy\push\models\ViewEvent',
        Message::TYPE_EVENT . Event::EVENT_SCANCODE_PUSH => 'cdcchen\wechat\qy\push\models\ScanCodePushEvent',
        Message::TYPE_EVENT . Event::EVENT_SCANCODE_WAITMSG => 'cdcchen\wechat\qy\push\models\ScanCodeWaitMsgEvent',
        Message::TYPE_EVENT . Event::EVENT_PIC_SYSPHOTO => 'cdcchen\wechat\qy\push\models\PicPhotoEvent',
        Message::TYPE_EVENT . Event::EVENT_PIC_PHOTO_OR_ALBUM => 'cdcchen\wechat\qy\push\models\PicPhotoAlbumEvent',
        Message::TYPE_EVENT . Event::EVENT_PIC_WEIXIN_PHOTO => 'cdcchen\wechat\qy\push\models\PicWeixinPhotoEvent',
        Message::TYPE_EVENT . Event::EVENT_LOCATION_SELECT => 'cdcchen\wechat\qy\push\models\LocationSelectEvent',
        Message::TYPE_EVENT . Event::EVENT_ENTER_AGENT => 'cdcchen\wechat\qy\push\models\EnterAgentEvent',
        Message::TYPE_EVENT . Event::EVENT_BATCH_JOB_RESULT => 'cdcchen\wechat\qy\push\models\BatchJobEvent',
    ];
}