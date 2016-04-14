<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:26
 */

namespace weixin\qy\suit;


use phpplus\net\CUrl;
use weixin\suit\Request;

class Service extends Request
{
    const TARGET_AGENT_SETTING = 'agent_setting';
    const TARGET_SEND_MSG = 'send_msg';
    const TARGET_CONTACT = 'contact';
    const TARGET_3RD_ADMIN = '3rd_admin';

    const API_GET_LOGIN_INFO = '/cgi-bin/service/get_login_info';
    const API_GET_LOGIN_URL = '/cgi-bin/service/get_login_url';

    public function getLoginInfo($auth_code)
    {
        $attributes = ['auth_code' => $auth_code];

        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_LOGIN_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) {
            return static::handleResponse($request, function($response) {
                return $response;
            });
        });
    }

    public function getLoginUrl($login_ticket, $target, $agent_id = null, $only_url = true)
    {
        $attributes = [
            'login_ticket' => $login_ticket,
            'target' => $target,
            'agentid' => $agent_id,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_LOGIN_URL);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) use ($only_url) {
            return static::handleResponse($request, function($response) use ($only_url) {
                unset($response['errcode'], $response['errmsg']);
                return $only_url ? $response['login_url'] : $response;
            });
        });
    }
}