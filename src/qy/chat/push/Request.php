<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:12
 */

namespace weixin\qy\chat\push;


use cdcchen\wechat\security\PrpCrypt;


class Request
{
    // @todo wait complete

    static protected $modelMap = [
    ];

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
}