<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/22
 * Time: 下午3:26
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\base\BaseRequest;
use cdcchen\wechat\base\Object;
use cdcchen\wechat\qy\sso\ProviderTokenRequest;
use cdcchen\wechat\qy\suite\SuiteTokenRequest;

/**
 * Class sToken
 * @package cdcchen\wechat\qy
 */
class TokenClient extends Object
{
    /**
     * @param BaseRequest $request
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    private static function fetch(BaseRequest $request)
    {
        $client = new DefaultClient();

        return $client->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }

    /**
     * @param AccessTokenRequest $request
     * @param bool $onlyToken
     * @return array
     */
    public static function getDefaultToken(AccessTokenRequest $request, $onlyToken = false)
    {
        $data = static::fetch($request);
        return $onlyToken ? $data['access_token'] : $data;
    }

    /**
     * @param ProviderTokenRequest $request
     * @param bool $onlyToken
     * @return array
     */
    public static function getProviderToken(ProviderTokenRequest $request, $onlyToken = false)
    {
        $data = static::fetch($request);
        return $onlyToken ? $data['provider_access_token'] : $data;
    }

    /**
     * @param SuiteTokenRequest $request
     * @param bool $onlyToken
     * @return array
     */
    public static function getSuiteToken(SuiteTokenRequest $request, $onlyToken = false)
    {
        $data = static::fetch($request);
        return $onlyToken ? $data['suite_access_token'] : $data;
    }
}