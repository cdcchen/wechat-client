<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:32
 */

namespace weixin\login;


use phpplus\net\CUrl;
use weixin\base\BaseRequest;
use weixin\base\ApiException;
use weixin\base\ResponseException;

class AccessToken extends BaseRequest
{
    const API_ACCESS_TOKEN = '/cgi-bin/service/get_provider_token';

    public static function fetch($suite_id, $provider_secret, $only_token = true)
    {
        $params = [
            'suite_id' => $suite_id,
            'provider_secret' => $provider_secret,
        ];

        $request = new CUrl();
        $url = Request::getRequestUrl(self::API_ACCESS_TOKEN);
        $request->post($url, $params);

        return static::handleRequest($request, function(CUrl $request) use ($only_token){
            $data = $request->getJsonData();
            static::checkAccessTokenResponse($data);

            return $only_token ? $data['provider_access_token'] : $data;
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