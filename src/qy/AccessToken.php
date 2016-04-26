<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午3:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\BaseClient;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\base\ApiException;

class AccessToken extends BaseClient
{
    const API_ACCESS_TOKEN = '/cgi-bin/gettoken';

    public static function fetch($corp_id, $corp_secret)
    {
        $params = [
            'corpid' => $corp_id,
            'corpsecret' => $corp_secret,
        ];

        $url = Client::getRequestUrl(self::API_ACCESS_TOKEN, $params);
        $request = HttpClient::get($url);

        return static::handleRequest($request, function(HttpResponse $response) {
            return static::handleResponse($response, function($data) {
                static::checkAccessTokenResponse($data);
                return $data;
            });
        });
    }

    protected static function checkAccessTokenResponse($data)
    {
        if (isset($data['access_token'])) {
            return true;
        }
        elseif (isset($data['errcode']))
            throw new ApiException($data['errmsg'], $data['errcode']);
        else
            throw new ResponseException('Get access token error.');
    }
}