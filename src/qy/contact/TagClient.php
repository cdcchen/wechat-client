<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 下午2:57
 */

namespace cdcchen\wechat\qy\contact;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\ResponseException;
use cdcchen\wechat\qy\Client;

class TagClient extends Client
{
    const API_CREATE       = '/cgi-bin/tag/create';
    const API_UPDATE       = '/cgi-bin/tag/update';
    const API_DELETE       = '/cgi-bin/tag/delete';
    const API_LIST         = '/cgi-bin/tag/list';
    const API_GET_USERS    = '/cgi-bin/tag/get';
    const API_ADD_USERS    = '/cgi-bin/tag/addtagusers';
    const API_DELETE_USERS = '/cgi-bin/tag/deltagusers';


    public function getAll()
    {
        $url = $this->buildUrl(self::API_LIST);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['taglist'];
        });
    }

    public function create($name, $id = 0)
    {
        $attributes = ['tagname' => $name];
        if ($id > 0) {
            $attributes['tagid'] = $id;
        }

        $url = $this->buildUrl(self::API_CREATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['tagid'];
        });
    }

    public function update($id, $name)
    {
        $attributes = [
            'tagid' => $id,
            'tagname' => $name,
        ];

        $url = $this->buildUrl(self::API_UPDATE);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function delete($id)
    {
        $url = $this->buildUrl(self::API_DELETE, ['tagid' => $id]);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    public function getUsers($id)
    {
        $url = $this->buildUrl(self::API_GET_USERS, ['tagid' => $id]);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['userlist'];
        });
    }

    public function addUsers($id, array $user_list = [], array $party_list = [])
    {
        if (empty($user_list) && empty($party_list)) {
            throw new \InvalidArgumentException('$user_list and $party_list can\'t at the same time is empty.');
        }

        $attributes = [
            'tagid' => $id,
            'userlist' => $user_list,
            'partylist' => $party_list,
        ];

        $url = $this->buildUrl(self::API_ADD_USERS);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            if ($data['invalidlist'] || $data['invalidparty']) {
                throw new ResponseException($data['errmsg'],
                    $data['invalidlist'] . $data['invalidparty']);
            } else {
                return true;
            }
        });
    }

    public function deleteUsers($id, array $user_list = [], array $party_list = [])
    {
        if (empty($user_list) && empty($party_list)) {
            throw new \InvalidArgumentException('$user_list and $party_list can\'t at the same time is empty.');
        }

        $attributes = [
            'tagid' => $id,
            'userlist' => $user_list,
            'partylist' => $party_list,
        ];

        $url = $this->buildUrl(self::API_DELETE_USERS);
        $request = HttpClient::post($url, $attributes)->setFormat(HttpRequest::FORMAT_JSON);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            $data = $response->getData();
            $invalid = [
                'invalidlist' => $data['invalidlist'],
                'invalidparty' => $data['invalidparty'],
            ];
            $invalid = array_filter($invalid);

            if ($invalid) {
                $invalidText = join('；', $invalid);
                throw new ResponseException($data['errmsg'] . $invalidText);
            } else {
                return true;
            }
        });
    }
}