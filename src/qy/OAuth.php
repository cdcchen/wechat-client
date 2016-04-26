<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午2:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;

class OAuth extends Client
{
    CONST URL_AUTHORIZE = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';
    const API_INFO = '/cgi-bin/user/getuserinfo';

    public static function buildAuthorizeUrl($app_id, $redirect_uri, $state = '')
    {
        return sprintf(self::URL_AUTHORIZE, $app_id, urlencode($redirect_uri), $state);
    }

    public function getUserInfo($code)
    {
        $url = $this->buildUrl(self::API_INFO, ['code' => $code]);
        $request = HttpClient::get($url);

        return static::handleRequest($request, function(HttpResponse $response){
            $data = $response->getData();
            if (isset($data['errcode'])) {
                throw new ResponseException($response['errmsg'], $response['errcode']);
            }
            else
                return $data;
        });
    }
}