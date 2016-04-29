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

/**
 * Class UserClient
 * @package cdcchen\wechat\qy\contact
 */
class UserClient extends Client
{
    /**
     * Api create path
     */
    const API_CREATE            = '/cgi-bin/user/create';
    /**
     * Api update path
     */
    const API_UPDATE            = '/cgi-bin/user/update';
    /**
     * Api delete path
     */
    const API_DELETE            = '/cgi-bin/user/delete';
    /**
     * Api get_item path
     */
    const API_GET_ITEM          = '/cgi-bin/user/get';
    /**
     * Api simple_list paht
     */
    const API_SIMPLE_LIST       = '/cgi-bin/user/simplelist';
    /**
     * Api detail_list path
     */
    const API_DETAIL_LIST       = '/cgi-bin/user/list';
    /**
     * Api batch_delete path
     */
    const API_BATCH_DELETE      = '/cgi-bin/user/batchdelete';
    /**
     * Api convert_to_openid path
     */
    const API_CONVERT_TO_OPENID = '/cgi-bin/user/convert_to_openid';
    /**
     * Api convert_to_userid path
     */
    const API_CONVERT_TO_USERID = '/cgi-bin/user/convert_to_userid';


    /**
     * @param User|array $attributes
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param string $user_id
     * @param User|array $attributes
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param string $user_id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function delete($user_id)
    {

        $url = $this->buildUrl(self::API_DELETE);
        $request = HttpClient::get($url, ['userid' => $user_id]);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param array $users
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param string $user_id
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param int $department_id
     * @param int $status
     * @param bool $fetch_child
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param int $department_id
     * @param int $status
     * @param bool $fetch_child
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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

    /**
     * @param string $user_id
     * @param int|null $agent_id
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getOpenIdByUserId($user_id, $agent_id = null)
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

    /**
     * @param string $open_id
     * @return string
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
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