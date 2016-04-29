<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午1:59
 */

namespace cdcchen\wechat\qy\menu;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\Client;

class MenuClient extends Client
{
    const API_CREATE = '/cgi-bin/menu/create';
    const API_DELETE = '/cgi-bin/menu/delete';
    const API_LIST   = '/cgi-bin/menu/get';

    public function create($agent_id, MenuButton $button)
    {
        $attributes = $button->toArray();

        $url = $this->buildUrl(self::API_CREATE, ['agentid' => $agent_id]);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function delete($agent_id)
    {
        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::post($url, ['agentid' => $agent_id])->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function select($agent_id)
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['menu'];
        });
    }
}