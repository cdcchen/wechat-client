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
 * Class LoginUrlRequest
 * @package cdcchen\wechat\qy\login
 */
class LoginUrlRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     */
    protected $action = '/cgi-bin/service/get_login_url';

    /**
     * @param string $value
     * @return $this
     */
    public function setLoginTicket($value)
    {
        return $this->setData('login_ticket', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTarget($value)
    {
        return $this->setData('target', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAgentId($value)
    {
        return $this->setData('agentid', $value);
    }

    /**
     * @return array
     */
    protected function getRequireParams()
    {
        return ['login_ticket', 'target'];
    }

}