<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午9:55
 */

namespace cdcchen\wechat\qy\suit;


use cdcchen\wechat\base\BaseClient;

class Client extends BaseClient
{
    const API_HOST = 'https://qyapi.weixin.qq.com';

    public function __construct($access_token)
    {
        if (empty($access_token))
            throw new \InvalidArgumentException('Access token is required.');

        $this->setAccessToken($access_token);
    }

    public static function getRequestUrl($path, $query = [], $access_token = '')
    {
        $url =  self::API_HOST . '/' . ltrim($path, '/');
        if ($access_token)
            $query['suit_access_token'] = $access_token;

        if ($query)
            $url .= '?' . http_build_query($query);

        return $url;
    }
}