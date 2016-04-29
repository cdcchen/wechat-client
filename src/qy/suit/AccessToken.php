<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:32
 */

namespace cdcchen\wechat\qy\suit;


use cdcchen\net\curl\HttpResponse;
use cdcchen\net\curl\Client as HttpClient;
use cdcchen\wechat\base\BaseClient;
use cdcchen\wechat\base\ApiException;
use cdcchen\wechat\base\ResponseException;

class AccessToken extends BaseClient
{
    const API_ACCESS_TOKEN = '/cgi-bin/service/get_suite_token';

    public static function fetch($suite_id, $suite_secret, $suite_ticket)
    {
        $params = [
            'suite_id' => $suite_id,
            'suite_secret' => $suite_secret,
            'suite_ticket' => $suite_ticket,
        ];

        $url = Client::getRequestUrl(self::API_ACCESS_TOKEN);
        $request = HttpClient::post($url, $params);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
                static::checkAccessTokenResponse($data);
                return $data;
        });
    }

    protected static function checkAccessTokenResponse($response)
    {
        if (isset($response['suite_access_token'])) {
            return true;
        }
        elseif (isset($response['errcode']))
            throw new ApiException($response['errmsg'], $response['errcode']);
        else
            throw new ResponseException('Get access token error.');
    }
}