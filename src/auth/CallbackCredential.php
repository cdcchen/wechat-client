<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/17
 * Time: 12:37
 */

namespace cdcchen\wechat\auth;


/**
 * Class CallbackCredential
 * @package cdcchen\wechat\auth
 */
class CallbackCredential
{
    /**
     * @var string
     */
    private $_url;
    /**
     * @var string
     */
    private $_token;
    /**
     * @var string
     */
    private $_encodingAesKey;

    /**
     * CallbackCredential constructor.
     * @param string $url
     * @param string $token
     * @param string $encodingAesKey
     */
    public function __construct($url, $token, $encodingAesKey)
    {
        if (empty($url) || empty($token) || empty($encodingAesKey)) {
            throw new \InvalidArgumentException('Url|Token|encodingAesKey is required.');
        }

        $this->_url = $url;
        $this->_token = $token;
        $this->_encodingAesKey = $encodingAesKey;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * @return string
     */
    public function getEncodingAesKey()
    {
        return $this->_encodingAesKey;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'url' => $this->_url,
            'token' => $this->_token,
            'encoding_aes_key' => $this->_encodingAesKey,
        ];
    }
}