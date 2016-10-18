<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/23
 * Time: 下午5:12
 */

namespace cdcchen\wechat\qy\chat\push;


use cdcchen\wechat\base\Object;
use cdcchen\wechat\qy\chat\push\models\MessagePackage;
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
    public function buildMessagePackage($body)
    {
        $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xml === false) {
            throw new \BadFunctionCallException('Load xml error.');
        }

        $crypt = new PrpCrypt($this->_encodingAesKey);
        $decrypt = $crypt->decrypt((string)$xml->Encrypt, $this->_corpId);

        return new MessagePackage($decrypt);
    }
}