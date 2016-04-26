<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:32
 */

namespace cdcchen\wechat\qy\login;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\BaseClient;
use cdcchen\wechat\base\ApiException;
use cdcchen\wechat\base\ResponseException;

class AccessToken extends BaseClient
{
    const API_ACCESS_TOKEN = '/cgi-bin/service/get_provider_token';

    public static function fetch($suite_id, $provider_secret)
    {
        $params = [
            'suite_id' => $suite_id,
            'provider_secret' => $provider_secret,
        ];

        $url = Client::getRequestUrl(self::API_ACCESS_TOKEN);
        $request = HttpClient::post($url, $params);

        return static::handleRequest($request, function(HttpResponse $response) {
            return static::handleResponse($response, function($data) {
                static::checkAccessTokenResponse($data);
                return $data;
            });
        });
    }

    protected static function checkAccessTokenResponse($response)
    {
        if (isset($response['provider_access_token'])) {
            return true;
        }
        elseif (isset($response['errcode']))
            throw new ApiException($response['errmsg'], $response['errcode']);
        else
            throw new ResponseException('Get access token error.');
    }
}