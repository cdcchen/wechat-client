<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/6/20
 * Time: 10:24
 */

namespace cdcchen\wechat\qy\suite;


use cdcchen\net\curl\HttpResponse;
use cdcchen\wechat\qy\ServiceClient;

/**
 * Class SuiteClient
 * @package cdcchen\wechat\qy\suite
 */
class SuiteClient extends ServiceClient
{
    /**
     * @param string $suiteId
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getPreAuthCode($suiteId)
    {
        $request = (new PreAuthCodeRequest())->setSuiteId($suiteId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }

    /**
     * @param string $preAuthCode
     * @param int $authType
     * @param array $appId
     * @return bool
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function setSessionInfo($preAuthCode, $authType = 0, $appId = [])
    {
        $request = (new SetSessionInfoRequest())
            ->setPreAuthCode($preAuthCode)
            ->setSessionInfo($authType, $appId);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return true;
        });
    }

    /**
     * @param string $suiteId
     * @param string $authCode
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getPermanentCode($suiteId, $authCode)
    {
        $request = (new PermanentCodeRequest())->setSuiteId($suiteId)->setAuthCode($authCode);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data;
        });
    }

    /**
     * @param string $suiteId
     * @param string $authCorpId
     * @param string $permanentCode
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getAuthInfo($suiteId, $authCorpId, $permanentCode)
    {
        $request = (new AuthInfoRequest())->setSuiteId($suiteId)
                                          ->setAuthCorpId($authCorpId)
                                          ->setPermanentCode($permanentCode);

        return $this->sendRequest($request, function (HttpResponse $response) {
            return $response->getData();
        });
    }

    /**
     * @param string $suiteId
     * @param string $authCorpId
     * @param string $permanentCode
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getCorpAccessToken($suiteId, $authCorpId, $permanentCode)
    {
        $request = (new CorpTokenRequest())->setSuiteId($suiteId)
                                           ->setAuthCorpId($authCorpId)
                                           ->setPermanentCode($permanentCode);

        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            unset($data['errcode'], $data['errmsg']);
            return $data;
        });
    }
}