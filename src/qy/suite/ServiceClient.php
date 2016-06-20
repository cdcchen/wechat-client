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
 * Class ServiceClient
 * @package cdcchen\wechat\qy
 */
class ServiceClient extends BaseClient
{
    /**
     * @var string
     */
    private $_accessToken;

    /**
     * BaseClient constructor.
     * @param string $access_token
     */
    public function __construct($access_token = '')
    {
        if ($access_token) {
            $this->setAccessToken($access_token);
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
     * @param string $access_token
     * @return $this
     */
    public function setAccessToken($access_token)
    {
        $this->_accessToken = $access_token;
        $this->setParam('suite_access_token', $access_token);

        return $this;
    }


}