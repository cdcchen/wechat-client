<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午1:48
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\Client;

class UserClient extends Client
{
    const API_CREATE            = '/cgi-bin/user/create';
    const API_UPDATE            = '/cgi-bin/user/update';
    const API_DELETE            = '/cgi-bin/user/delete';
    const API_GET_ITEM          = '/cgi-bin/user/get';
    const API_SIMPLE_LIST       = '/cgi-bin/user/simplelist';
    const API_DETAIL_LIST       = '/cgi-bin/user/list';
    const API_BATCH_DELETE      = '/cgi-bin/user/batchdelete';
    const API_CONVERT_TO_OPENID = '/cgi-bin/user/convert_to_openid';
    const API_CONVERT_TO_USERID = '/cgi-bin/user/convert_to_userid';


    public function create($attributes)
    {
        if ($attributes instanceof User) {
            $attributes = $attributes->toArray();
        }
        unset($attributes['enable']);

        $url = $this->buildUrl(self::API_CREATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function update($user_id, $attributes)
    {
        if ($attributes instanceof User) {
            $attributes = $attributes->toArray();
        }

        $attributes['userid'] = $user_id;
        if (count($attributes) <= 1) {
            throw new \InvalidArgumentException('There is no attributes need to be updated.');
        }

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function delete($user_id)
    {

        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::get($url, ['userid' => $user_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function batchDelete($users)
    {
        $attributes = ['useridlist' => $users];


        $url = $this->buildUrl(self::API_BATCH_DELETE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function fetch($user_id)
    {

        $url = $this->buildUrl(self::API_GET_ITEM);
        $request = HttpClient::get($url, ['userid' => $user_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data;
        });

    }

    public function getSimpleList($department_id, $status = 0, $fetch_child = false)
    {
        $attributes = [
            'department_id' => (int)$department_id,
            'status' => (int)$status,
            'fetch_child' => $fetch_child ? 1 : 0,
        ];


        $url = $this->buildUrl(self::API_SIMPLE_LIST);
        $request = HttpClient::get($url, $attributes);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userlist'];
        });
    }

    public function getDetailList($department_id, $status = 0, $fetch_child = false)
    {
        $attributes = [
            'department_id' => (int)$department_id,
            'status' => (int)$status,
            'fetch_child' => $fetch_child ? 1 : 0,
        ];


        $url = $this->buildUrl(self::API_DETAIL_LIST);
        $request = HttpClient::get($url, $attributes);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userlist'];
        });
    }

    public function getOpenIdByUserId($user_id, $agent_id = '')
    {
        $attributes = ['userid' => $user_id];
        if ($agent_id) {
            $attributes['agentid'] = $agent_id;
        }


        $url = $this->buildUrl(self::API_CONVERT_TO_OPENID);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    public function getUserIdByOpenId($open_id)
    {
        $attributes = ['openid' => $open_id];


        $url = $this->buildUrl(self::API_CONVERT_TO_USERID);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userid'];
        });
    }

}