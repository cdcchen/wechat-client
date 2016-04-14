<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:26
 */

namespace weixin\qy\login;


use phpplus\net\CUrl;
use weixin\suit\Request;

class Service extends Request
{
    const API_GET_PRE_AUTH_CODE = '/cgi-bin/service/get_provider_token';
    const API_SET_SESSION_INFO = '/cgi-bin/service/set_session_info';
    const API_GET_PERMANENT_CODE = '/cgi-bin/service/get_permanent_code';
    const API_GET_AUTH_INFO = '/cgi-bin/service/get_auth_info';
    const API_GET_CORP_TOKEN = '/cgi-bin/service/get_corp_token';

    public function getPreAuthCode($suite_id, $only_code = true)
    {
        $attributes = ['suite_id' => $suite_id];

        $request = new CUrl();
        $url = $this->getUrl(self::API_GET_PRE_AUTH_CODE);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) use ($only_code) {
            return static::handleResponse($request, function($response) use ($only_code) {
                unset($response['errcode'], $response['errmsg']);
                return $only_code ? $response['pre_auth_code'] : $response;
            });
        });
    }

    public function setSessionInfo($pre_auth_code, array $session_info)
    {
        $attributes = [
            'pre_auth_code' => $pre_auth_code,
            'session_info' => $session_info,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_SET_SESSION_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) {
            return static::handleResponse($request, function($response) {
                unset($response['errcode'], $response['errmsg']);
                return true;
            });
        });
    }

    public function getPermanentCode($suite_id, $auth_code)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_code' => $auth_code,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_SET_SESSION_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) {
            return static::handleResponse($request, function($response) {
                return $response;
            });
        });
    }

    public function getAuthInfo($suite_id, $auth_corp_id, $permanent_code)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_corpid' => $auth_corp_id,
            'permanent_code' => $permanent_code,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_SET_SESSION_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) {
            return static::handleResponse($request, function($response) {
                return $response;
            });
        });
    }

    public function getCorpAccessToken($suite_id, $auth_corp_id, $permanent_code, $only_token)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_corpid' => $auth_corp_id,
            'permanent_code' => $permanent_code,
        ];

        $request = new CUrl();
        $url = $this->getUrl(self::API_SET_SESSION_INFO);
        $request->post($url, json_encode($attributes, 320));

        return static::handleRequest($request, function(CUrl $request) use ($only_token) {
            return static::handleResponse($request, function($response) use ($only_token) {
                unset($response['errcode'], $response['errmsg']);
                return $only_token ? $response['access_token'] : $response;
            });
        });
    }
}