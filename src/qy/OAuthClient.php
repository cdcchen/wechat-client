<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午2:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;

/**
 * Class OAuth
 * @package cdcchen\wechat\qy
 */
class OAuthClient extends DefaultClient
{
    /**
     * authorize url
     */
    const URL_AUTHORIZE = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';

    /**
     * @param string $corpId
     * @param string $redirectUri
     * @param string $state
     * @return string
     */
    public static function buildAuthorizeUrl($corpId, $redirectUri, $state = '')
    {
        return sprintf(self::URL_AUTHORIZE, $corpId, urlencode($redirectUri), $state);
    }


    /**
     * @param string $code
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getUserInfo($code)
    {
        $request = new OAuthUserInfoRequest();
        $request->setCode($code);
        return $this->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }
}