<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午2:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\Client as HttpClient;
use cdcchen\wechat\base\ResponseException;

/**
 * Class OAuth
 * @package cdcchen\wechat\qy
 */
class OAuth extends Client
{
    /**
     * authorize url
     */
    CONST URL_AUTHORIZE = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';
    /**
     * api path
     */
    const API_INFO = '/cgi-bin/user/getuserinfo';

    /**
     * @param string $corp_id
     * @param string $redirect_uri
     * @param string $state
     * @return string
     */
    public static function buildAuthorizeUrl($corp_id, $redirect_uri, $state = '')
    {
        return sprintf(self::URL_AUTHORIZE, $corp_id, urlencode($redirect_uri), $state);
    }

    /**
     * @param string $code
     * @return array
     * @throws ResponseException
     * @throws \cdcchen\wechat\base\RequestException
     */
    public function getUserInfo($code)
    {
        $url = $this->buildUrl(self::API_INFO, ['code' => $code]);
        $request = HttpClient::get($url);
        $response = static::sendRequest($request);

        $data = $response->getData();
        if (isset($data['errcode'])) {
            throw new ResponseException($response['errmsg'], $response['errcode']);
        } else {
            return $data;
        }
    }
}