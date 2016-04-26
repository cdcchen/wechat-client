<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午1:59
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;

class Menu extends Client
{
    const API_CREATE = '/cgi-bin/menu/create';
    const API_DELETE = '/cgi-bin/menu/delete';
    const API_LIST = '/cgi-bin/menu/get';

    public function create($agent_id, $attributes)
    {
        if (!isset($attributes['button']))
            $attributes = ['button' => $attributes];

        $url = $this->getUrl(self::API_CREATE, ['agentid' => $agent_id]);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    public function delete($agent_id)
    {
        $url = $this->getUrl(self::API_DELETE);
        $request = HttpClient::post($url, ['agentid' => $agent_id])->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    public function select($agent_id)
    {
        $url = $this->getUrl(self::API_LIST);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                unset($data['errcode'], $data['errmsg']);
                return $data;
            });
        });
    }
}