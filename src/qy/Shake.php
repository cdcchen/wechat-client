<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/9
 * Time: 22:15
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;

class Shake extends Client
{
    const API_GET_SHAKE_INFO = '/cgi-bin/shakearound/getshakeinfo';

    public function getInfo($ticket)
    {
        $attributes = ['ticket' => $ticket];

        $url = $this->getUrl(self::API_GET_SHAKE_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['data'];
            });
        });
    }
}