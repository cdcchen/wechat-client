<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 15/7/27
 * Time: 下午4:32
 */

namespace weixin\qy;


use phpplus\net\CUrl;

class Server extends Request
{
    const API_IP_LIST = '/cgi-bin/getcallbackip';

    public function getCallbackIP()
    {
        $request = new CUrl();
        $url = $this->getUrl(self::API_IP_LIST);
        $request->get($url);

        return static::handleRequest($request, function(CUrl $request){
            return static::handleResponse($request, function($response){
                return $response['ip_list'];
            });
        });
    }
}