<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午3:26
 */

namespace weixin\qy;


use phpplus\net\CUrl;
use weixin\base\BaseRequest;
use weixin\base\ApiException;
use weixin\base\ResponseException;

class AccessToken extends BaseRequest
{
    const API_ACCESS_TOKEN = '/cgi-bin/gettoken';

    public static function fetch($corp_id, $corp_secret, $only_token = true)
    {
        $params = [
            'corpid' => $corp_id,
            'corpsecret' => $corp_secret,
        ];

        $request = new CUrl();
        $request->get(Request::getRequestUrl(self::API_ACCESS_TOKEN), $params);

        return static::handleRequest($request, function(CUrl $request) use ($only_token){
            $data = $request->getJsonData();
            static::checkAccessTokenResponse($data);

            return $only_token ? $data['access_token'] : $data;
        });
    }

    protected static function checkAccessTokenResponse($data)
    {
        if (isset($data['access_token'])) {
            return true;
        }
        elseif (isset($data['errcode']))
            throw new ApiException($data['errmsg'], $data['errcode']);
        else
            throw new ResponseException('Get access token error.');
    }
}