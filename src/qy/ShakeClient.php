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

/**
 * Class ShakeClient
 * @package cdcchen\wechat\qy
 */
class ShakeClient extends Client
{
    /**
     *
     */
    const API_GET_SHAKE_INFO = '/cgi-bin/shakearound/getshakeinfo';

    /**
     * @param string $ticket
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getInfo($ticket)
    {
        $attributes = ['ticket' => $ticket];

        $url = $this->buildUrl(self::API_GET_SHAKE_INFO);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['data'];
        });
    }
}