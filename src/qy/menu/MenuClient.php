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

/**
 * Class MenuClient
 * @package cdcchen\wechat\qy\menu
 */
class MenuClient extends Client
{
    /**
     * Api create path
     */
    const API_CREATE = '/cgi-bin/menu/create';
    /**
     * Api delete path
     */
    const API_DELETE = '/cgi-bin/menu/delete';
    /**
     * Api list path
     */
    const API_LIST = '/cgi-bin/menu/get';

    /**
     * @param int $agent_id
     * @param MenuButton $button
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param int $agent_id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($agent_id)
    {
        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::get($url, ['agentid' => $agent_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $agent_id
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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