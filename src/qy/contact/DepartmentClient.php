<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午10:23
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\Client;

/**
 * Class DepartmentClient
 * @package cdcchen\wechat\qy\contact
 */
class DepartmentClient extends Client
{
    /**
     * Api create path
     */
    const API_CREATE = '/cgi-bin/department/create';
    /**
     * Api update path
     */
    const API_UPDATE = '/cgi-bin/department/update';
    /**
     * Api delete path
     */
    const API_DELETE = '/cgi-bin/department/delete';
    /**
     * Api list path
     */
    const API_LIST = '/cgi-bin/department/list';


    /**
     * @param null|int $id
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function select($id = null)
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url, ['id' => $id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['department'];
        });
    }

    /**
     * @param string $name
     * @param int $parent_id
     * @param int $order
     * @param int $id
     * @return int
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function create($name, $parent_id = 1, $order = 0, $id = 0)
    {
        $attributes = [
            'name' => $name,
            'parentid' => $parent_id,
        ];

        if ($order > 0) {
            $attributes['order'] = $order;
        }
        if ($id > 0) {
            $attributes['id'] = $id;
        }

        $url = $this->buildUrl(self::API_CREATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['id'];
        });
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $parent_id
     * @param null|int $order
     * @return mixed
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function update($id, $name, $parent_id = 1, $order = null)
    {
        $attributes = [
            'id' => $id,
            'name' => $name,
            'parentid' => $parent_id,
        ];

        if (is_int($order)) {
            $attributes['order'] = $order;
        }

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($id)
    {
        $attributes = ['id' => $id];

        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::get($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }
}