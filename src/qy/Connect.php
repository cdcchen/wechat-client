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
     * @param string $corp_id 公众平台的corpid
     * @param string $token 公众平台上，开发者设置的token
     * @param string $encoding_aes_key 公众平台上，开发者设置的EncodingAESKey
     */
    public function __construct($corp_id, $token, $encoding_aes_key)
    {
        $this->_token = $token;
        $this->_encodingAesKey = $encoding_aes_key;
        $this->_corpId = $corp_id;
    }

    /**
     * 验证URL
     *
     * @param string $msg_signature : 签名串，对应URL参数的msg_signature
     * @param string $timestamp : 时间戳，对应URL参数的timestamp
     * @param string $nonce : 随机串，对应URL参数的nonce
     * @param string $echo_str : 随机串，对应URL参数的echostr
     * @return string 成功返回0，失败返回对应的错误码
     */
    public function verifyURL($msg_signature, $timestamp, $nonce, $echo_str)
    {
        if (strlen($this->_encodingAesKey) !== self::ENCODING_AES_KEY_LENGTH) {
            return false;
        }

        $pc = new PrpCrypt($this->_encodingAesKey);

        try {
            $signature = $this->getSignature($timestamp, $nonce, $echo_str);
        } catch (\Exception $e) {
            return false;
        }

        if ($signature != $msg_signature) {
            return false;
        }

        return $pc->decrypt($echo_str, $this->_corpId);
    }

    /**
     * @param string $timestamp
     * @param string $nonce
     * @param string $echo_str
     * @return string
     */
    protected function getSignature($timestamp, $nonce, $echo_str)
    {
        return BaseClient::getSHA1($this->_token, $timestamp, $nonce, $echo_str);
    }
}