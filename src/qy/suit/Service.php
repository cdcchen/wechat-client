<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:26
 */

namespace cdcchen\wechat\qy\suit;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;

class Service extends Client
{
    const API_GET_PRE_AUTH_CODE  = '/cgi-bin/service/get_provider_token';
    const API_SET_SESSION_INFO   = '/cgi-bin/service/set_session_info';
    const API_GET_PERMANENT_CODE = '/cgi-bin/service/get_permanent_code';
    const API_GET_AUTH_INFO      = '/cgi-bin/service/get_auth_info';
    const API_GET_CORP_TOKEN     = '/cgi-bin/service/get_corp_token';

    public function getPreAuthCode($suite_id)
    {
        $attributes = ['suite_id' => $suite_id];

        $url = $this->buildUrl(self::API_GET_PRE_AUTH_CODE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    public function setSessionInfo($pre_auth_code, array $session_info)
    {
        $attributes = [
            'pre_auth_code' => $pre_auth_code,
            'session_info' => $session_info,
        ];

        $url = $this->buildUrl(self::API_SET_SESSION_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return true;
        });
    }

    public function getPermanentCode($suite_id, $auth_code)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_code' => $auth_code,
        ];

        $url = $this->buildUrl(self::API_SET_SESSION_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data;
        });
    }

    public function getAuthInfo($suite_id, $auth_corp_id, $permanent_code)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_corpid' => $auth_corp_id,
            'permanent_code' => $permanent_code,
        ];

        $url = $this->buildUrl(self::API_SET_SESSION_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return $response->getData();
        });
    }

    public function getCorpAccessToken($suite_id, $auth_corp_id, $permanent_code)
    {
        $attributes = [
            'suite_id' => $suite_id,
            'auth_corpid' => $auth_corp_id,
            'permanent_code' => $permanent_code,
        ];

        $url = $this->buildUrl(self::API_SET_SESSION_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }
}