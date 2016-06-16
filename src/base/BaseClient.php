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


/**
 * Class BaseClient
 * @package cdcchen\wechat\base
 */
abstract class BaseClient extends Object
{
    /**
     * api host url
     */
    protected static $host = 'https://qyapi.weixin.qq.com';

    /**
     * @var array
     */
    private $_params = [];

    /**
     * @param string $token
     * @param string $timestamp
     * @param string $nonce
     * @param string $encrypt_msg
     * @return string
     */
    public static function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
    {
        $params = [$encrypt_msg, $token, $timestamp, $nonce];
        sort($params, SORT_STRING);
        $str = implode('', $params);

        return sha1($str);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setParam($name, $value)
    {
        $this->_params[$name] = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }
        return $this;
    }

    /**
     * prepare before send request
     */
    public function prepare()
    {
    }


    /**
     * @param BaseRequest $request
     * @return HttpRequest
     */
    private function buildHttpRequest(BaseRequest $request)
    {
        $httpRequest = (new HttpRequest())
            ->setSSL()
            ->setMethod($request->getMethod())
            ->setUrl($request->getRequestUrl());

        if ($request->isPost()) {
            $httpRequest->setFormat(HttpRequest::FORMAT_JSON);
        }

        if (is_array($request->getData())) {
            $httpRequest->setData($request->getData());
        } else {
            $httpRequest->setContent($request->getData());
        }

        return $httpRequest;
    }

    /**
     * @param BaseRequest $request
     * @param callable|null $success
     * @return HttpResponse|mixed
     * @throws RequestException
     * @throws ResponseException
     * @throws \cdcchen\net\curl\RequestException
     */
    public function sendRequest(BaseRequest $request, callable $success = null)
    {
        $this->prepare();

        $request->setHost(static::$host)
                ->mergeQueryParams($this->_params);
        $request->validate();

        $httpRequest = $this->buildHttpRequest($request);

        /* @var HttpResponse $response */
        $response = $httpRequest->send();

        $httpCode = (int)$response->getStatus();
        if ($httpCode !== 200) {
            throw new RequestException('Http request error.', $httpCode);
        }

        $data = $response->getData();
        if (isset($data['errcode']) && $data['errcode'] != 0) {
            throw new ResponseException($data['errmsg'], $data['errcode']);
        }

        return $success ? call_user_func($success, $response) : $response;
    }
}