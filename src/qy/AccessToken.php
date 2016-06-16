<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午3:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\Object;

/**
 * Class AccessToken
 * @package cdcchen\wechat\qy
 */
class AccessToken extends Object
{
    /**
     * @param string $corpId
     * @param string $corpSecret
     * @return array 
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public static function fetch($corpId, $corpSecret)
    {
        $client = new DefaultClient();
        $request = (new AccessTokenRequest())->setCorpId($corpId)->setCorpSecret($corpSecret);

        return $client->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }
}