<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午9:55
 */

namespace cdcchen\wechat\qy\login;


use cdcchen\wechat\base\BaseClient;

class Client extends BaseClient
{
    const API_HOST = 'https://qyapi.weixin.qq.com';

    protected static function getRequestUrl($path, $query = [], $access_token = '')
    {
        $url = self::API_HOST . '/' . ltrim($path, '/');
        if ($access_token) {
            $query['access_token'] = $access_token;
        }

        if ($query) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }
}