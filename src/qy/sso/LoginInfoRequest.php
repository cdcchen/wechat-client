<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 09:52
 */

namespace cdcchen\wechat\qy\sso;


use cdcchen\wechat\base\BaseRequest;

/**
 * Class LoginInfoRequest
 * @package cdcchen\wechat\qy\login
 */
class LoginInfoRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_login_info';

    /**
     * @param string $code
     * @return $this
     */
    public function setAuthCode($code)
    {
        return $this->setData('auth_code', $code);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['auth_code'];
    }

}