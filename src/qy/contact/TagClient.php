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

/**
 * Class TagClient
 * @package cdcchen\wechat\qy\contact
 */
class TagClient extends Client
{
    /**
     * Api create path
     */
    const API_CREATE = '/cgi-bin/tag/create';
    /**
     * Api update path
     */
    const API_UPDATE = '/cgi-bin/tag/update';
    /**
     * Api delete path
     */
    const API_DELETE = '/cgi-bin/tag/delete';
    /**
     * Api list path
     */
    const API_LIST = '/cgi-bin/tag/list';
    /**
     * Api get_users path
     */
    const API_GET_USERS = '/cgi-bin/tag/get';
    /**
     * Api add_users path
     */
    const API_ADD_USERS = '/cgi-bin/tag/addtagusers';
    /**
     * Api delete_users path
     */
    const API_DELETE_USERS = '/cgi-bin/tag/deltagusers';


    /**
     * @return array
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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

    /**
     * @param string $name
     * @param int $id
     * @return int
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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

    /**
     * @param int $id
     * @param string $name
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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

    /**
     * @param int $id
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function delete($id)
    {
        $url = $this->buildUrl(self::API_DELETE, ['tagid' => $id]);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        return static::handleResponse($response, function (HttpResponse $response) {
            return true;
        });
    }

    /**
     * @param int $id
     * @return array
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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

    /**
     * @param int $id
     * @param array $user_list
     * @param array $party_list
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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
                $message = sprintf('%s, invalid users: %s, invalid parties: %s.', $data['errmsg'], $data['invalidlist'],
                    join('|', $data['invalidparty']));
                throw new ResponseException($message);
            } else {
                return true;
            }
        });
    }

    /**
     * @param int $id
     * @param array $user_list
     * @param array $party_list
     * @return bool
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
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