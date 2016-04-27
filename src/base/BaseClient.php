<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/13
 * Time: 21:44
 */

namespace cdcchen\wechat\base;


use cdcchen\net\curl\HttpRequest;
use cdcchen\net\curl\HttpResponse;


class BaseClient extends Object
{
    protected $_accessToken;

    public function __construct($access_token)
    {
        if (empty($access_token)) {
            throw new \InvalidArgumentException('Access token is required.');
        }

        $this->setAccessToken($access_token);
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function setAccessToken($access_token)
    {
        $this->_accessToken = $access_token;
        return $this;
    }


    public static function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
    {
        $params = [$encrypt_msg, $token, $timestamp, $nonce];
        sort($params, SORT_STRING);
        $str = implode('', $params);

        return sha1($str);
    }

    protected function buildUrl($path, $query = [])
    {
        return static::getRequestUrl($path, $query, $this->getAccessToken());
    }

    /**
     * @param $path
     * @param array $query
     * @param string $access_token
     * @return string
     * @throws \Exception
     */
    protected static function getRequestUrl($path, $query = [], $access_token = '')
    {
        throw new \Exception('This method should be override.');
    }


    /**
     * @param HttpRequest $request
     * @param callable|null $success
     * @param callable|null $failed
     * @return bool|\cdcchen\net\curl\Response
     * @throws RequestException
     */
    protected static function handleRequest(HttpRequest $request, callable $success = null, callable $failed = null)
    {
        try {
            $response = $request->send();
            if ($success === null) {
                return $response;
            } else {
                return call_user_func($success, $response);
            }
        } catch (\Exception $e) {
            if ($failed) {
                return call_user_func($failed, $request);
            } else {
                throw new RequestException($e->getMessage(), $e->getCode());
            }
        }
    }

    /**
     * @param HttpResponse $response
     * @param callable|null $success
     * @param callable|null $failed
     * @return mixed
     * @throws ResponseException
     */
    protected static function handleResponse(HttpResponse $response, callable $success = null, callable $failed = null)
    {
        $data = $response->getData();
        if ($data['errcode'] == 0 || !isset($data['errcode'])) {
            return call_user_func($success, $data);
        } else {
            if ($failed) {
                return call_user_func($failed, $data);
            } else {
                throw new ResponseException($data['errmsg'], $data['errcode']);
            }
        }
    }
}