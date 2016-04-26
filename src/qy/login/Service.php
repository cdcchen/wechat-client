<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:26
 */

namespace cdcchen\wechat\qy\login;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;

class Service extends Client
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

        $url = $this->buildUrl(self::API_GET_LOGIN_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data;
            });
        });
    }

    public function getLoginUrl($login_ticket, $target, $agent_id = null)
    {
        $attributes = [
            'login_ticket' => $login_ticket,
            'target' => $target,
            'agentid' => $agent_id,
        ];

        $url = $this->buildUrl(self::API_GET_LOGIN_URL);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                unset($data['errcode'], $data['errmsg']);
                return $data;
            });
        });
    }
}