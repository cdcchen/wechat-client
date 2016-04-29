<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/21
 * Time: 上午9:55
 */

namespace cdcchen\wechat\qy;


use cdcchen\wechat\base\BaseClient;


/**
 * Class Client
 * @package cdcchen\wechat\qy
 */
class Client extends BaseClient
{
    /**
     * api host
     */
    const API_HOST = 'https://qyapi.weixin.qq.com';

    /**
     * @param string $path
     * @param array $query
     * @param string $access_token
     * @return string
     */
    public static function getRequestUrl($path, $query = [], $access_token = '')
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