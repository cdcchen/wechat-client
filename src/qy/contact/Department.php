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

class Department extends Client
{
    const API_CREATE = '/cgi-bin/department/create';
    const API_UPDATE = '/cgi-bin/department/update';
    const API_DELETE = '/cgi-bin/department/delete';
    const API_LIST   = '/cgi-bin/department/list';


    public function select($id = null)
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url, ['id' => $id]);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['department'];
            });
        });
    }

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

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return $data['id'];
            });
        });
    }

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

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }

    public function delete($id)
    {
        $attributes = ['id' => $id];

        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::get($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);

        return static::handleRequest($request, function (HttpResponse $response) {
            return static::handleResponse($response, function ($data) {
                return true;
            });
        });
    }
}