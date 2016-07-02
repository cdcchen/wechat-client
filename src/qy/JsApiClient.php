<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/7/2
 * Time: 17:04
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\jsapi\GroupTicketRequest;
use cdcchen\wechat\qy\jsapi\JsApiTicketRequest;

/**
 * Class JsApiClient
 * @package cdcchen\wechat\qy
 */
class JsApiClient extends DefaultClient
{
    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getJsApiTicket()
    {
        $request = (new JsApiTicketRequest());

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getGroupTicket()
    {
        $request = (new GroupTicketRequest());

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param string $ticket
     * @param string $url
     * @param string $noncestr
     * @param int $timestamp
     * @return string
     */
    public static function generateJsApiSignature($ticket, $url, $noncestr, $timestamp)
    {
        $url = strstr($url, '#', true) ?: $url;
        $paramsStr = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";

        return sha1($paramsStr);
    }

    /**
     * @param string $ticket
     * @param string $url
     * @param string $noncestr
     * @param int $timestamp
     * @return string
     */
    public static function generateGroupSignature($ticket, $url, $noncestr, $timestamp)
    {
        $url = strstr($url, '#', true) ?: $url;
        $paramsStr = "group_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";

        return sha1($paramsStr);
    }
}