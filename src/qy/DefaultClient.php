<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午9:55
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseClient;


/**
 * Class DefaultClient
 * @package cdcchen\wechat\qy
 */
class DefaultClient extends BaseClient
{
    /**
     * @var string
     */
    private $_accessToken;

    /**
     * BaseClient constructor.
     * @param string $token
     */
    public function __construct($token = '')
    {
        if ($token) {
            $this->setAccessToken($token);
        }
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setAccessToken($token)
    {
        $this->_accessToken = $token;
        $this->setParam('access_token', $token);

        return $this;
    }


}