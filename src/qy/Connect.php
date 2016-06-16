<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午3:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseClient;
use cdcchen\wechat\security\PrpCrypt;

/**
 * Class Connect
 * @package cdcchen\wechat\qy
 */
class Connect
{
    /**
     * aes key length
     */
    const ENCODING_AES_KEY_LENGTH = 43;

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
     * @param string $corpId 公众平台的corpid
     * @param string $token 公众平台上，开发者设置的token
     * @param string $encodingAesKey 公众平台上，开发者设置的EncodingAESKey
     */
    public function __construct($corpId, $token, $encodingAesKey)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;
        $this->_corpId = $corpId;
    }

    /**
     * 验证URL
     *
     * @param string $msgSignature : 签名串，对应URL参数的msg_signature
     * @param string $timestamp : 时间戳，对应URL参数的timestamp
     * @param string $nonce : 随机串，对应URL参数的nonce
     * @param string $echoStr : 随机串，对应URL参数的echostr
     * @return string 成功返回0，失败返回对应的错误码
     */
    public function verifyURL($msgSignature, $timestamp, $nonce, $echoStr)
    {
        if (strlen($this->_encodingAesKey) !== self::ENCODING_AES_KEY_LENGTH) {
            return false;
        }

        $pc = new PrpCrypt($this->_encodingAesKey);

        try {
            $signature = $this->getSignature($timestamp, $nonce, $echoStr);
        } catch (\Exception $e) {
            return false;
        }

        if ($signature != $msgSignature) {
            return false;
        }

        return $pc->decrypt($echoStr, $this->_corpId);
    }

    /**
     * @param string $timestamp
     * @param string $nonce
     * @param string $echoStr
     * @return string
     */
    protected function getSignature($timestamp, $nonce, $echoStr)
    {
        return BaseClient::getSHA1($this->_token, $timestamp, $nonce, $echoStr);
    }
}