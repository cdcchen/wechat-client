<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/27
 * Time: 下午4:32
 */

namespace cdcchen\wechat\qy;


use cdcchen\net\curl\HttpResponse;

/**
 * Class ServerClient
 * @package cdcchen\wechat\qy
 */
class ServerClient extends DefaultClient
{
    /**
     * @return array
     * @throws \cdcchen\wechat\base\RequestException
     * @throws \cdcchen\wechat\base\ResponseException
     */
    public function getCallbackIP()
    {
        $request = new CallbackServerIPRequest();
        return $this->sendRequest($request, function (HttpResponse $response) {
            $data = $response->getData();
            return $data['ip_list'];
        });
    }
}