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
     * @param string $corpId
     * @param string $corpSecret
     * @param bool $onlyToken
     * @return array
     */
    public static function getDefaultToken($corpId, $corpSecret, $onlyToken = false)
    {
        $request = (new AccessTokenRequest())->setCorpId($corpId)->setCorpSecret($corpSecret);
        $data = static::fetch($request);
        return $onlyToken ? $data['access_token'] : $data;
    }

    /**
     * @param string $corpId
     * @param string $providerSecret
     * @param bool $onlyToken
     * @return array
     */
    public static function getProviderToken($corpId, $providerSecret, $onlyToken = false)
    {
        $request = (new ProviderTokenRequest())->setCorpId($corpId)->setProviderSecret($providerSecret);
        $data = static::fetch($request);
        return $onlyToken ? $data['provider_access_token'] : $data;
    }

    /**
     * @param string $suiteId
     * @param string $authCorpId
     * @param string $permanentCode
     * @param bool $onlyToken
     * @return array
     */
    public static function getSuiteToken($suiteId, $authCorpId, $permanentCode, $onlyToken = false)
    {
        $request = (new SuiteTokenRequest())->setSuitId($suiteId)
                                            ->setAuthCorpId($authCorpId)
                                            ->setPermanentCode($permanentCode);
        $data = static::fetch($request);
        return $onlyToken ? $data['suite_access_token'] : $data;
    }
}