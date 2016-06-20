<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:30
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class SetSessionInfoRequest
 * @package cdcchen\wechat\qy\suite
 */
class SetSessionInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgin-bin/service/set_session_info';

    /**
     * @param $value
     * @return $this
     */
    public function setPreAuthCode($value)
    {
        return $this->setData('pre_auth_code', $value);
    }

    /**
     * @param int $authType
     * @param array $appId
     * @return $this
     */
    public function setSessionInfo($authType, array $appId = [])
    {
        $info = ['appid' => $appId, 'auth_type' => (int)$authType];
        return $this->setData('session_info', $info);
    }

}