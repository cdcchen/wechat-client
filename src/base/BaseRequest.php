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


abstract class BaseRequest extends Object
{
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