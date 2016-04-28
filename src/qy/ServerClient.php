<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/27
 * Time: 下午4:32
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpResponse;

class ServerClient extends Client
{
    const API_IP_LIST = '/cgi-bin/getcallbackip';

    public function getCallbackIP()
    {
        $url = $this->buildUrl(self::API_IP_LIST);
        $request = HttpClient::get($url);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['ip_list'];
            });
        });
    }
}