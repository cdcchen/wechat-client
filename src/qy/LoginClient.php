<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\sso\LoginInfoRequest;
use cdcchen\wechat\qy\sso\LoginUrlRequest;

/**
 * Class LoginService
 * @package cdcchen\wechat\qy\login
 */
class LoginClient extends DefaultClient
{
    /**
     * Redirect target page: agent setting
     */
    const TARGET_AGENT_SETTING = 'agent_setting';
    /**
     * Redirect target page: send msg
     */
    const TARGET_SEND_MSG = 'send_msg';
    /**
     * Redirect target page: contact manage
     */
    const TARGET_CONTACT = 'contact';
    /**
     * Redirect target page: 3rd admin
     */
    const TARGET_3RD_ADMIN = '3rd_admin';

    /**
     * Member user type
     */
    const USER_TYPE_MEMBER = 'member';
    /**
     * Admin user type
     */
    const USER_TYPE_ADMIN = 'admin';
    /**
     * member and admin
     */
    const USER_TYPE_ALL = 'all';

    /**
     * @var string
     */
    private static $loginUrl = 'https://qy.weixin.qq.com/cgi-bin/loginpage?corp_id=%s&redirect_uri=%s&state=%s&usertype=%s';

    /**
     * @param string $corpId
     * @param string $redirectUrl
     * @param null|string $state
     * @param null|string $userType
     * @return string
     */
    public static function buildLoginUrl($corpId, $redirectUrl, $state = null, $userType = null)
    {
        return sprintf(static::$loginUrl, $corpId, $redirectUrl, $state, $userType);
    }

    /**
     * @param string $authCode
     * @return HttpResponse|mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getLoginInfo($authCode)
    {
        $request = (new LoginInfoRequest())->setAuthCode($authCode);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data;
        });
    }

    /**
     * @param string $ticket
     * @param string $target
     * @param null|int $agentId
     * @return HttpResponse|mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getLoginUrl($ticket, $target, $agentId = null)
    {
        $request = (new LoginUrlRequest())->setLoginTicket($ticket)->setTarget($target);
        if ($agentId) {
            $request->setAgentId($agentId);
        }

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }
}